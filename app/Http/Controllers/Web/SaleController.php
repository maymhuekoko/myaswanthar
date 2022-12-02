<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Employee;
use App\Order;
use App\Item;
use App\Category;
use App\SubCategory;
use App\Customer;
use App\SalesCustomer;
use App\CountingUnit;
use App\Voucher;
use DateTime;

class SaleController extends Controller
{
    protected function getSalePanel(){

    	return view('Sale.sale_panel');

    }

    protected function getSalePage(){

        $items = Item::all();

        $categories = Category::all();
        
        $sub_categories = SubCategory::all();

        $customers = Customer::all();

        $employees = Employee::all();

        $date = new DateTime('Asia/Yangon');

        $today_date = strtotime($date->format('d-m-Y H:i'));
    	
    	return view('Sale.sale_page',compact('items','categories','customers','employees','today_date','sub_categories'));
    }

    protected function getVucherPage(Request $request){

        $date = new DateTime('Asia/Yangon');

        $today_date = $date->format('d-m-Y h:i:s');

        $check_date = $date->format('Y-m-d');

        $items = json_decode($request->item);

        $grand = json_decode($request->grand);

        $last_voucher = Voucher::get()->last();

        $voucher_code =  "VOU-".date('dmY')."-".sprintf("%04s", ($last_voucher->id + 1));
        
        $salescustomers = SalesCustomer::all();

        return view('Sale.voucher', compact('items','today_date','grand','voucher_code','salescustomers'));
    }

    protected function storeVoucher(request $request){

        $user = session()->get('user');

        $date = new DateTime('Asia/Yangon');

        $today_date = $date->format('d-m-Y h:i:s');

        $voucher_date = $date->format('Y-m-d');

        $today_time = $date->format('g:i A');
 
        $items = json_decode(json_encode($request->item));

        $grand = json_decode(json_encode($request->grand));

        $total_quantity = $grand->total_qty;

        $total_amount = $grand->sub_total;

        $voucher = Voucher::create([
            'sale_by' => $user->id,
            'voucher_code' => $request->voucher_code,
            'total_price' =>  $total_amount,
            'total_quantity' => $total_quantity,
            'voucher_date' => $voucher_date,
            'type' => 1,
            'status' => 0,
            'sales_customer_id' => $request->sales_customer_id,
            'sales_customer_name' => $request->sales_customer_name,
            
        ]);
        
         if(isset($request->credit_amount) && $request->credit_amount != 0){
             $sales_customer = SalesCustomer::find($request->sales_customer_id);
             $sales_customer->credit_amount += $request->credit_amount;
             $sales_customer->deleted_at = null;
             $sales_customer->save();
         }

        foreach ($items as $item) {
            
            $voucher->counting_unit()->attach($item->id, ['quantity' => $item->order_qty,'price' => $item->selling_price]);

            $counting_unit = CountingUnit::find($item->id);

            $balance_qty = ($counting_unit->current_quantity - $item->order_qty);

            $counting_unit->current_quantity = $balance_qty;

            $counting_unit->save();

        }
        
        return response()->json($voucher);
        
    }

    public function getCountingUnitsByItemId(request $request){

        $item_id = $request->item_id;
        
        $item = Item::where('id', $item_id)->first();
        
        $units = CountingUnit::where('item_id', $item->id)->where('current_quantity', '!=', 0)->with('item')->get();
        
        return response()->json($units);

    }

    public function getCountingUnitsByItemCode(Request $request){

        $unit_code = $request->unit_code;
       
        $units = CountingUnit::where('unit_code', $unit_code)->orWhere('original_code', $unit_code)->with('item')->first();

        return response()->json($units);
    }

    protected function getSaleHistoryPage(){
        
        $voucher_lists =Voucher::where('type', 1)->get();
        
        $total_sales  = 0;
        
        foreach ($voucher_lists as $voucher_list){

            $total_sales += $voucher_list->total_price;

        }
        
        $date = new DateTime('Asia/Yangon');
        
        $current_date = strtotime($date->format('Y-m-d'));
        
        $weekly = date('Y-m-d', strtotime('-1week', $current_date));
        
        $weekly_data = Voucher::where('type', 1)->whereBetween('created_at', [$current_date, $weekly])->get();
        
        $weekly_sales = 0;
        
        foreach($weekly_data as $weekly){
            
            $weekly_sales += $weekly->total_price;
        }

        $current_month = $date->format('m');
        
        $today_date = $date->format('d');
        
        $daily = Voucher::where('type', 1)->whereDay('created_at', $today_date)->get();
        
        $daily_sales = 0;
        
        foreach($daily as $day){
            
            $daily_sales += $day->total_price;
        }
        
        $monthly = Voucher::where('type', 1)->whereMonth('created_at',$current_month)->get();

        $monthly_sales = 0;
        
        foreach ($monthly as $month){

            $monthly_sales += $month->total_price;
        }


        return view('Sale.sale_history_page',compact('voucher_lists','total_sales','daily_sales','monthly_sales','weekly_sales'));
    }

    protected function searchSaleHistory(Request $request){

        $validator = Validator::make($request->all(), [
            'from' => 'required',
            'to' => 'required',
        ]);

        if ($validator->fails()) {

            alert()->error('Something Wrong!');

            return redirect()->back();
        }

        $voucher_lists = Voucher::where('type', 1)->whereBetween('voucher_date', [$request->from, $request->to])->get();

        $voucher_lists_all = Voucher::where('type', 1);
        
        $total_sales  = 0;
        
        foreach ($voucher_lists_all as $voucher_list){

            $total_sales += $voucher_list->total_price;

        }
        
        $date = new DateTime('Asia/Yangon');
        
        $current_date = strtotime($date->format('Y-m-d'));
        
        $weekly = date('Y-m-d', strtotime('-1week', $current_date));
        
        $weekly_data = Voucher::where('type', 1)->whereBetween('created_at', [$current_date, $weekly])->get();
        
        $weekly_sales = 0;
        
        foreach($weekly_data as $weekly){
            
            $weekly_sales += $weekly->total_price;
        }

        $current_month = $date->format('m');
        
        $today_date = $date->format('d');
        
        $daily = Voucher::where('type', 1)->whereDay('created_at', $today_date)->get();
        
        $daily_sales = 0;
        
        foreach($daily as $day){
            
            $daily_sales += $day->total_price;
        }
        
        $monthly = Voucher::where('type', 1)->whereMonth('created_at',$current_month)->get();

        $monthly_sales = 0;
        
        foreach ($monthly as $month){

            $monthly_sales += $month->total_price;
        }

        return view('Sale.sale_history_page',compact('voucher_lists','total_sales','daily_sales','monthly_sales','weekly_sales'));

    }

    protected function getVoucherDetails(request $request, $id){

        $voucher = Voucher::find($id);
        
        return view('Sale.voucher_details', compact('voucher'));
    }
    
    protected function getVoucherSummaryMain(){
        return view('Sale.voucher_history');
    }
    
    public function searchItemSalesByDate(Request $request){  // PYin Yan
        
        $search_date = $request->date;
        
        $req_date = strtotime($search_date);
		
		$date = date('d/F/Y', $req_date);
        
        $vouchers = Voucher::whereDate('created_at', $search_date)->get();
        
        if(count($vouchers) == 0){
            
            alert()->error('ယနေ့အတွက် ဘောင်ချာမရှိသေးပါ');
            
            return redirect()->back();
        }
        
        $total_sales = 0;
        
        $total_quantity = 0;
        
        $item_lists = array();
        
        foreach($vouchers as $voucher){
            
            $total_sales += $voucher->total_price;
            
            $total_quantity += $voucher->total_quantity;
            
            foreach($voucher->counting_unit as $counting_unit){
                
                $counting_unit_id = $counting_unit->id;
                
                $item_id = $counting_unit->item_id;
                
                $item_name = Item::find($item_id)->item_name;
                
                $counting_unit_name = $counting_unit->unit_name;
                
                $quantity = $counting_unit->pivot->quantity;
                
                $price = $counting_unit->pivot->price;
                
                $combined = array('item_id' => $item_id, 'item_name' => $item_name, 'counting_unit_id' => $counting_unit_id,'counting_unit_name' => $counting_unit_name, 'quantity' => $quantity, 'price' =>$price );
                
                array_push($item_lists, $combined);
            }
            
        }
        
        $items = array();
        
        foreach ($item_lists as $item) {
            
            if (!isset($result[$item['counting_unit_id']])){
            
                $result[$item['counting_unit_id']] = $item;
            }else{
            
                $result[$item['counting_unit_id']]['quantity'] += $item['quantity'];
                $result[$item['counting_unit_id']]['price'] += $item['price'];
            }
        }
        
        $items = array_values($result);
        asort($items);
        
        return view('Sale.voucher_summary',compact('total_sales','total_quantity','items','date'));
    }
}


