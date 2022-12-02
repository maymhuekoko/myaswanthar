<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Category;
use App\SubCategory;
use App\Item;
use App\CountingUnit;
use App\UnitRelation;
use App\UnitConversion;

class InventoryController extends Controller
{
	protected function getInventoryDashboard()
	{
		return view('Inventory.inv_dashboard');
	}

	protected function categoryList()
	{
		$category_lists =  Category::whereNull("deleted_at")->get();

		return view('Inventory.category_list', compact('category_lists'));
	}

	protected function storeCategory(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'category_code' => 'required',
            'category_name' => 'required',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        }


        $user_code = $request->session()->get('user')->user_code;

        try {

            $category = Category::create([
                'category_name' => $request->category_name,
                'created_by' => $user_code,
            ]);
            
            $category->category_code = sprintf('%03s',$request->category_code);
            
            $category->save();
            
        } catch (\Exception $e) {
            
            alert()->error('Something Wrong! When Creating Category.');

            return redirect()->back();
        }
    
    	
    	alert()->success('Successfully Added');

        return redirect()->route('category_list');
	}

	protected function updateCategory($id, Request $request)
	{
		try {
            
        	$category = Category::findOrFail($id);

   		} catch (\Exception $e) {
   		    
        	alert()->error("Category Not Found!")->persistent("Close!");
            
            return redirect()->back();

    	}
    	
        $category->category_code = $request->category_code;

        $category->category_name = $request->category_name;
        
        $category->save();
        
        alert()->success('Successfully Updated!');

        return redirect()->route('category_list');
	}

	protected function deleteCategory(Request $request)
	{
		$id = $request->category_id;
        
        $category = Category::find($id);

        $items = Item::where('category_id', $id)->get();

        foreach ($items as $item) {
            
            foreach ($item->counting_units as $unit) {
                
                $unit->delete();
            }
        }

        $items = Item::where('category_id', $id)->delete();

        $category->delete();
        
        return response()->json($category);
	}
	
	protected function subcategoryList()
	{
		$categories = Category::all();
		
		$sub_categories = SubCategory::all();
		
		return view('Inventory.subcategory_list', compact('categories','sub_categories'));
	}
	
	protected function storeSubCategory(request $request){
	    
	    $validator = Validator::make($request->all(), [
            'sub_category_code' => 'required',
            'sub_category_name' => 'required',
            'category' => 'required',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        }


            $sub_category = SubCategory::create([
                'name' => $request->sub_category_name,
                'category_id' => $request->category,
            ]);
            
            $sub_category->subcategory_code = sprintf('%03s',$request->sub_category_code);
            
            $sub_category->save();
            
    	alert()->success('Successfully Added');

        return redirect()->route('subcategory_list'); 
	}
	
	protected function updateSubCategory(request $request, $id){
	   
	   try {
            
        	$sub_category = SubCategory::findOrFail($id);

   		} catch (\Exception $e) {
   		    
        	alert()->error("Category Not Found!")->persistent("Close!");
            
            return redirect()->back();

    	}
    	
        $sub_category->subcategory_code = $request->sub_category_code;

        $sub_category->name = $request->sub_category_name;
        
        $sub_category->save();
        
        alert()->success('Successfully Updated!');

        return redirect()->route('subcategory_list'); 
	    
	}
	
	protected function showSubCategory(request $request){
	    
	    $category_id = $request->category_id;
	    
	    $subcategory = SubCategory::where('category_id', $category_id)->get();
	    
	    return response()->json($subcategory);
	}

	protected function itemList()
	{
		$item_lists =  Item::whereNull("deleted_at")->orderBy('category_id', 'ASC')->get();

		$categories =  Category::whereNull("deleted_at")->get();
		
		$sub_categories = SubCategory::all();

		return view('Inventory.item_list', compact('item_lists','categories','sub_categories'));
	}

	protected function storeItem(Request $request)
	{

		$validator = Validator::make($request->all(), [
            'item_code' => 'required',
            'item_name' => 'required',
            'category_id' => 'required',
            'sub_category_id' => 'required',
        ]);

        if ($validator->fails()) {

        	alert()->error('Validation Error!');

            return redirect()->back();
        }

        $user_code = $request->session()->get('user')->user_code;

        if (isset($request->customer_console)) {
        	
        	$customer_console = 0;   //Customer ko pya mar
        }else{

        	$customer_console = 1;	//Customer ko ma pya
        }

        if ($request->hasfile('photo_path')) {

			$image = $request->file('photo_path');

			$name = $image->getClientOriginalName();

			$photo_path =  time()."-".$name;

			$image->move(public_path() . '/photo/Item', $photo_path);
		}
		else{

			$photo_path = "default.jpg";

		}

        try {

            $item = Item::create([
                'item_code' => $request->item_code,
                'item_name' => $request->item_name,
                'created_by' => $user_code,
                'photo_path' => $photo_path,
                'customer_console' => $customer_console,
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
            ]);
            
        } catch (\Exception $e) {
            
            alert()->error('Something Wrong! When Creating Item.');

            return redirect()->back();
        }

        alert()->success('Successfully Added');

        return redirect()->route('item_list');
	}

    protected function updateItem($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_code' => 'required',
            'item_name' => 'required',
        ]);

        if ($validator->fails()) {

            alert()->error('Something Wrong!');

            return redirect()->back();
        }

        try {
            
            $item = Item::findOrFail($id);

        } catch (\Exception $e) {
            
            alert()->error("Item Not Found!")->persistent("Close!");
            
            return redirect()->back();

        }

        if ($request->hasfile('photo_path')) {

            $image = $request->file('photo_path');

            $name = $image->getClientOriginalName();

            $photo_path =  time()."-".$name;

            $image->move(public_path() . '/photo/Item', $photo_path);
        }else{

            $photo_path = $item->photo_path;
        }
        

        $item->item_code = $request->item_code;

        $item->item_name = $request->item_name;

        $item->category_id = $request->category_id;
        
        $item->sub_category_id = $request->sub_category_id;

        $item->photo_path = $photo_path;

        $item->save();

        alert()->success('Successfully Updated!');

        return redirect()->back();
    }

    protected function deleteItem(Request $request)
    {
        $id = $request->item_id;

        $item = Item::find($id);

        $counting_units = CountingUnit::where('item_id', $item->id)->get();

        foreach ($counting_units as $unit) {
                
            $unit->delete();
        }

        $item->delete();

        return response()->json($item);
    }

	protected function getUnitList($item_id)
    {

		$units = CountingUnit::where('item_id', $item_id)->whereNull("deleted_at")->get();
        
        try {
            
        	$item = Item::findOrFail($item_id);

   		} catch (\Exception $e) {
   		    
        	alert()->error("Item Not Found!")->persistent("Close!");
            
            return redirect()->back();
    	}

    	return view('Inventory.unit_list', compact('units','item'));
	}

	protected function storeUnit(Request $request)
    {

		$validator = Validator::make($request->all(), [
            'name' => 'required',
            'current_qty' => 'required',
            'reorder_qty' => 'required',
            'purchase_price' => 'required',
            'normal_price' => 'required',
            'whole_price' => 'required',
            'order_price' => 'required',
        ]);

        if ($validator->fails()) {

            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {

            $counting_unit = CountingUnit::create([
                'unit_name' => $request->name,
                'current_quantity' => $request->current_qty,
                'reorder_quantity' => $request->reorder_qty,
                'normal_sale_price' => $request->normal_price,
                'whole_sale_price' => $request->whole_price,
                'purchase_price' => $request->purchase_price,
                'order_price' => $request->order_price,
                'item_id' => $request->item_id,
            ]);
            
        } catch (\Exception $e) {
            
            alert()->error('Something Wrong! When Creating Counting Unit.');

            return redirect()->back();
        }

        alert()->success('Successfully Stored!');

        return redirect()->back();
	}

    protected function updateUnit($id,Request $request)
    {
        try {
            
            $unit = CountingUnit::findOrFail($id);

        } catch (\Exception $e) {
            
            alert()->error("Counting Unit Not Found!")->persistent("Close!");
            
            return redirect()->back();

        }

        $unit->unit_name = $request->name;

        $unit->save();

        alert()->success('Successfully Stored!');

        return redirect()->back();
    }

    protected function updateUnitCode($id, Request $request)
    {

        try {
            
            $unit = CountingUnit::findOrFail($id);

        } catch (\Exception $e) {
            
            alert()->error("Counting Unit Not Found!")->persistent("Close!");
            
            return redirect()->back();

        }

        $unit->unit_code = $request->code;

        $unit->save();

        alert()->success('Successfully Stored!');

        return redirect()->back();
    }
    
    protected function updateOriginalCode($id, Request $request)
    {
        try {
            
            $unit = CountingUnit::findOrFail($id);

        } catch (\Exception $e) {
            
            alert()->error("Counting Unit Not Found!")->persistent("Close!");
            
            return redirect()->back();

        }

        $unit->original_code = $request->code;

        $unit->save();

        alert()->success('Successfully Stored!');

        return redirect()->back();
    }

    protected function deleteUnit(Request $request)
    {
        $id = $request->unit_id;
        
        $unit = CountingUnit::find($id);

        $unit->delete();
        
        return response()->json($unit);
    }

    protected function unitRelationList($item_id)
    {
        
        $unit_relation = UnitRelation::where('item_id', $item_id)->get();
        
        $item = Item::find($item_id);
        
        $counting_units = CountingUnit::where('item_id', $item_id)->get();
        
        return view('Inventory.unit_relation', compact('unit_relation','item','counting_units')); 
        
    }

    protected function storeUnitRelation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from_unit' => 'required|numeric',
            'to_unit' => 'required|numeric',
            'qty' => 'required|numeric',
        ]);

        if($validator->fails()){

            alert()->error('အချက်အလက် များ မှားယွင်း နေပါသည်။');

            return redirect()->route('unit_relation_list', $request->item_id);
        }

        $unit_relation = UnitRelation::where('item_id', request('item_id'))
            ->where('from_unit', request('from_unit'))
            ->where('to_unit', request('to_unit'))
            ->first();

        $unit_relation_rev = UnitRelation::where('item_id', request('item_id'))
            ->where('from_unit', request('to_unit'))
            ->where('to_unit', request('from_unit'))
            ->first();

        if(!empty($unit_relation) || !empty($unit_relation_rev)){
            
            alert()->error('This Relation has already Exist!');

            return redirect()->route('unit_relation_list', $request->item_id); 
            
        }else{

            try {

                $unit_relation = UnitRelation::create([
                        "item_id" => $request->item_id,
                        "from_unit" => $request->from_unit,
                        "to_unit" => $request->to_unit,
                        "quantity" => $request->qty,
                ]);
            
            } catch (\Exception $e) {
                
                alert()->error('Something Wrong! When Unit Realation.');

                return redirect()->back();
            }

            alert()->success('Successfully Added!');

            return redirect()->route('unit_relation_list', $request->item_id);
        }
    }

    protected function updateUnitRelation($id, Request $request)
    {
        try {
            
            $category = Category::findOrFail($id);

        } catch (\Exception $e) {
            
            alert()->error("Category Not Found!")->persistent("Close!");
            
            return redirect()->back();

        }
    }

    protected function deleteUnitRelation(Request $request)
    {
        dd("Hello");
    }

    protected function convertUnit($unit_id)
    {
        
        $unit = UnitRelation::find($unit_id);
        
        return view ('Inventory.unit_convert', compact('unit'));
    }

    protected function ajaxConvertResult(Request $request)
    {
        
        $unit_id = $request->unit_id;
        
        $from = $request->from;

        $to = $request->to;

        $qty = $request->qty;

        $unit = UnitRelation::find($unit_id); 

        $result_qty_one = $qty * $unit->quantity;

        $from_unit_balance = $unit->to_unit_detail->current_quantity - $qty;

        $to_unit_balance = $unit->from_unit_detail->current_quantity + $result_qty_one;
        
        $to_unit = CountingUnit::find($request->to);
        
        $to_unit->current_quantity = $to_unit_balance;
        
        $to_unit->save();
        
        $from_unit = CountingUnit::find($request->from);
        
        $from_unit->current_quantity = $from_unit_balance;
        
        $from_unit->save();
       
        $unit_conversion_log = UnitConversion::create([
            "item_id" => $unit->item_id,
            "from_unit_id" => $request->from,
            "from_unit_quantity" => $from_unit_balance,
            "to_unit_id" => $request->to,
            "to_unit_quantity" => $to_unit_balance,
        ]);

        return response()->json([
            'from_unit_quantity' => $from_unit_balance,
            'from_unit' => $from_unit->unit_name,
            'to_unit_quantity' => $to_unit_balance,
            'to_unit' => $to_unit->unit_name,
        ]); 
        
    }

    protected function convertCountUnit(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'item_id' => 'required',
            'unit_id' => 'required',
            'result_qty' => 'required',
            'result_unit' => 'required',
            'from_unit_id' => 'required',
            'from_unit_qty' => 'required',
            'to_unit_id' => 'required',
            'to_unit_qty' => 'required',
        ]);

        if($validator->fails()){

            alert()->error('အချက်အလက် များ မှားယွင်း နေပါသည်။');

            return redirect()->back();
        }
        
        $to_unit = CountingUnit::find($request->to_unit_id);
        
        $to_unit->current_quantity = $request->to_unit_qty;
        
        $to_unit->save();
        
        $from_unit = CountingUnit::find($request->from_unit_id);
        
        $from_unit->current_quantity = $request->from_unit_qty;
        
        $from_unit->save();
        
        $unit_conversion_log = UnitConversion::create([
            "item_id" => $request->item_id,
            "from_unit_id" => $request->from_unit_id,
            "from_unit_quantity" => $request->from_unit_qty,
            "to_unit_id" => $request->to_unit_id,
            "to_unit_quantity" => $request->to_unit_qty,
        ]);
        
        
        alert()->success("Successfully Converted!");
        
        return redirect()->route('count_unit_list', ['item_id' => $request->item_id]);
    }

    protected function AjaxGetItem(Request $request){

        $category = $request->category;

        $items = Item::where('category_id', $category)->whereNull('deleted_at')->get();
        
        return response()->json($items);
    }

    protected function AjaxGetCountingUnit(Request $request){

        $item = $request->item;

        $counting_units = CountingUnit::where('item_id', $item)->whereNull('deleted_at')->with('item.category')->get();

        return response()->json($counting_units);
    }
}
