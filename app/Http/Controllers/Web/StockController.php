<?php

namespace App\Http\Controllers\Web;

use App\Category;
use App\CountingUnit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    protected function getStockPanel()
    {
    	return view('Stock.stock_panel');
    }

    protected function getStockCountPage()
    {
        $units = CountingUnit::whereNull('deleted_at')->orderBy('item_id', 'asc')->get();

        $categories = Category::whereNull('deleted_at')->get();

    	return view('Stock.stock_count_page', compact('units','categories'));
    }

    protected function getStockPricePage()
    {
        $units = CountingUnit::whereNull('deleted_at')->orderBy('item_id', 'asc')->get();

        $categories = Category::whereNull('deleted_at')->get();

    	return view('Stock.stock_price_page', compact('units','categories'));
    }

    protected function getStockReorderPage()
    {

        $count_units = CountingUnit::whereColumn('current_quantity', "<=" ,'reorder_quantity')->whereNull("deleted_at")->get();

    	return view('Stock.reorder_page', compact('count_units'));
    }

    protected function updateStockCount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unit_id' => 'required',
            'quantity' => 'required',
        ]);

        if ($validator->fails()) {

            alert()->error('Something Wrong! Validation Error!');

            return redirect()->back();
        }

        $id = $request->unit_id;

        try {
            
            $unit = CountingUnit::findOrFail($id);

        } catch (\Exception $e) {
            
            alert()->error("Counting Unit Not Found!")->persistent("Close!");
            
            return redirect()->back();

        }

        $unit->current_quantity = $request->quantity;

        $unit->reorder_quantity = $request->reorder??$unit->reorder_quantity;

        $unit->save();

        alert()->success('Successfully Updated!');

        return redirect()->back();
    }

    protected function updateStockPrice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'unit_id' => 'required',
            'purchase_price' => 'required',
            'normal_sale_price' => 'required',
            'whole_sale_price' => 'required',
            'order_price' => 'required',
        ]);

        if ($validator->fails()) {

            alert()->error('Something Wrong! Validation Error!');

            return redirect()->back();
        }

        $id = $request->unit_id;

        try {
            
            $unit = CountingUnit::findOrFail($id);

        } catch (\Exception $e) {
            
            alert()->error("Counting Unit Not Found!")->persistent("Close!");
            
            return redirect()->back();

        }

        $unit->purchase_price = $request->purchase_price;

        $unit->normal_sale_price = $request->normal_sale_price;

        $unit->whole_sale_price = $request->whole_sale_price;

        $unit->order_price = $request->order_price;

        $unit->save();

        alert()->success('Successfully Updated!');

        return redirect()->back();
    }
}
