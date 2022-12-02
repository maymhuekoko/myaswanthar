<?php

namespace App\Http\Controllers\Web;

use App\Category;
use App\Customer;
use App\CountingUnit;
use App\Employee;
use App\Expense;
use App\Item;
use App\User;
use App\Order;
use App\Purchase;
use App\Voucher;
use App\SalesCustomer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller {

    protected function getAdminDashboard(){

	   return view('Admin.admin_panel');
	}
	
	protected function expenseList(request $request){
	    
	    $expenses = Expense::all();
	    
	    return view('Admin.expense', compact('expenses'));
	}
	
	protected function storeExpense(request $request){
	    
	       $validator = Validator::make($request->all(), [
            "type" => "required",
            "title" => "required",
            "description" => "required",
            "amount" => "required",
            "profit_loss_flag" => "required",
    
        ]);

        if($validator->fails()){

            alert()->error('အချက်အလက် များ မှားယွင်း နေပါသည်။');

            return redirect()->back();
        }
        
        $item = Expense::create([
                'type' => $request->type,
                'period' => $request->period,
                'date' => $request->date,
                'title' => $request->title,
                'description' => $request->description,
                'amount' => $request->amount,
                'profit_loss_flag' => $request->profit_loss_flag,
        ]);
        
        return redirect()->back();
	}

	protected function getEmployeeList(){

        $employee = Employee::all();

		return view('Admin.employee_list', compact('employee'));
	}


    protected function storeSalesCustomer(Request $request){
            $sales_customer = SalesCustomer::create([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'credit_amount' => $request->credit_amount
                ]); 
        return response()->json([
                "success" => 1,
                "message" => "Customer is successfully added",
            ]);
        
    }
    
    protected function getSalesCustomerList(){
        $salescustomer = SalesCustomer::all();
        return response()->json($salescustomer);
    }
    
    protected function getSalesCustomerWithID(Request $request){
       
        $salescustomerwID = SalesCustomer::findOrFail($request->customer_id);
        return response()->json($salescustomerwID);
    }

    protected function storeEmployee(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:App\User,email',
            'password' => 'required',
            'phone' => 'required',
            'role' => 'required',
        ]);

        if ($validator->fails()) {

            alert()->error("Something Wrong! Validation Error");

            return redirect()->back();
        }

        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Hash::make($request->password),
                'role' => $request->role,
                'prohibition_flag' => 1,
                'photo_path' => "user.jpg",
            ]);

            $user->user_code = "SHW-".sprintf('%03s', $user->id);

            $user->save();

            $employee = Employee::create([
                'phone' => $request->phone,
                'user_id' => $user->id,
            ]);
            
        } catch (\Exception $e) {
            
            alert()->error('Something Wrong! When Creating Emplyee.');

            return redirect()->back();
        }

        alert()->success('Successfully Added');

        return redirect()->route('employee_list');
    }

    protected function getEmployeeDetails($id){

        try {
            
            $employee = Employee::findOrFail($id);

        } catch (\Exception $e) {
            
            alert()->error("Employee Not Found!")->persistent("Close!");
            
            return redirect()->back();

        }

        return view('Admin.employee_details', compact('employee'));
    }

	protected function getCustomerList(){

		$customer_lists = Customer::all();

		return view('Admin.customer_list', compact('customer_lists'));
	}

	protected function storeCustomer(Request $request){

		$validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'level' => 'required',
        ]);

        if ($validator->fails()) {

        	alert()->error("Something Wrong! Validation Error");

            return redirect()->back();
        }

        $count_cus = count(Customer::all());
        
        

        if ($count_cus == 40) {
            
            alert()->error("Your Customer Count is full!");

            return redirect()->back();

        } else {

           
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => \Hash::make($request->password),
                    'role' => "Customer",
                    'prohibition_flag' => 1,
                    'photo_path' => "user.jpg",
                ]);

                $user->user_code = "SHW-CUS-".sprintf('%03s', $user->id);

                $user->save();

                $customer = Customer::create([
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'allow_credit' => $request->allow_credit = "on"?1:0,
                    'customer_level' => $request->level,
                    'user_id' => $user->id,
                ]);
            
            

            alert()->success('Successfully Added');

            return redirect()->route('customer_list');
        }
	}

    protected function getCustomerDetails($id){

        try {
            
            $customer = Customer::findOrFail($id);

        } catch (\Exception $e) {
            
            alert()->error("Customer Not Found!")->persistent("Close!");
            
            return redirect()->back();

        }

        $order_lists = Order::where('customer_id', $customer->id)->get();

       return view('Admin.customer_details', compact('customer','order_lists'));
    }
    
    protected function updateCustomer(Request $request, $id){
        
        $validator = Validator::make($request->all(), [
			'name' => 'required',
			'email' => 'required',
			'phone' => 'required',
			'address' => 'required',
		]);

		if ($validator->fails()) {			

			return $this->sendFailResponse("Something Wrong! Validation Error.", "400");
		}
        
        try {
            
            $customer = Customer::findOrFail($id);
            
            $user = User::findOrFail($customer->user_id);

        } catch (\Exception $e) {
            
            alert()->error("Customer Not Found!")->persistent("Close!");
            
            return redirect()->back();

        }
        
        $user->name = $request->name;
        
        $user->email = $request->email;
        
        $user->save();
        
        $customer->phone = $request->phone;

		$customer->address = $request->address;

		$customer->save();

		alert()->success("Successfully Updated Customer!");
		
		return redirect()->route('customer_list');
    }

    protected function changeCustomerLevel(Request $request){

        try {
            
            $customer = Customer::findOrFail($request->customer_id);

            $customer->customer_level = $request->level;

            $customer->save();

            alert()->success('Successfully Updated');

            return redirect()->back();

        } catch (\Exception $e) {
            
            alert()->error("Customer Not Found!")->persistent("Close!");
            
            return redirect()->back();

        }
    }

    protected function getCustomerInfo(Request $request){

        $customer = Customer::where('id',$request->customer_id)->with('user')->first();

        return response()->json($customer);
    }

    protected function getPurchaseHistory(Request $request){

        $purchase_lists = Purchase::all();

        return view('Purchase.purchase_lists', compact('purchase_lists'));
    }

    protected function createPurchaseHistory(){

        $units = CountingUnit::all();

        $categories =  Category::all();

        $items = Item::all();

        return view('Purchase.create_purchase', compact('units','categories','items'));
    }

    protected function getPurchaseHistoryDetails($id){

        try {  

            $purchase = Purchase::findOrFail($id);

        } catch (\Exception $e) {
            
            alert()->error('Something Wrong! Purchase Cannot be Found.');

            return redirect()->back();
        }

        return view('Purchase.purchase_details', compact('purchase'));

    }

    protected function storePurchaseHistory(Request $request){

        $validator = Validator::make($request->all(), [
            'purchase_date' => 'required',
            'supp_name' => 'required',
            'unit' => 'required',
            'price' => 'required',
            'qty' => 'required',
        ]);

        if ($validator->fails()) {

            alert()->error("Something Wrong! Validation Error");

            return redirect()->back();
        }

        $user_code = $request->session()->get('user')->id;

        $unit = $request->unit;

        $price = $request->price;

        $qty = $request->qty;

        $total_qty = 0;

        $total_price = 0;
        
        $psub_total = 0;
        
        foreach($price as $p){
            foreach($qty as $q){
                $psub_total = $p * $q;
                $total_price += $psub_total;
            }
        }

        foreach ($qty as $q) {
            
            $total_qty += $q;
        }

        try {

            $purchase = Purchase::create([
                'supplier_name' => $request->supp_name,
                'total_quantity' => $total_qty,
                'total_price' => $total_price,
                'purchase_date' => $request->purchase_date,
                'purchase_by' => $user_code,
            ]);


            for($count = 0; $count < count($unit); $count++){

                $purchase->counting_unit()->attach($unit[$count], ['quantity' => $qty[$count], 'price' => $price[$count]]);

                $counting_unit = CountingUnit::find($unit[$count]);

                $balance_qty = ($counting_unit->current_quantity + $qty[$count]);

                $counting_unit->current_quantity = $balance_qty;

                $counting_unit->purchase_price = $price[$count];

                $counting_unit->save();
                
            }

        } catch (\Exception $e) {
            
            alert()->error('Something Wrong! When Purchase Store.');

            return redirect()->back();
        }

        alert()->success("Success");
            
        return redirect()->route('purchase_list');
    }
    
    protected function getTotalSalenAndProfit(Request $request){

        return view('Admin.financial_panel');
    }

    protected function getTotalSaleReport(Request $request){

        $type = $request->type;

        $total_sales = 0;

        $total_profit = 0;

        if($type == 1){

            $daily = date('Y-m-d', strtotime($request->value));

            $voucher_lists = Voucher::whereDate('voucher_date', $daily)->get();

        }
        elseif($type == 2){

            $week_count = $request->value;

            $start_month = date('Y-m-d',strtotime('first day of this month'));

            if ($week_count == 1) {
                
                $end_date = date('Y-m-d', strtotime("+1 week" , strtotime($start_month)));

                $voucher_lists = Voucher::whereBetween('voucher_date', [$start_month, $end_date])->get();

            } elseif ($week_count == 2) {
                
                $start_date = date('Y-m-d', strtotime("+1 week" , strtotime($start_month)));
                
                $end_date = date('Y-m-d', strtotime("+2 week" , strtotime($start_month)));

                $voucher_lists = Voucher::whereBetween('voucher_date', [$start_date, $end_date])->get();

            } elseif ($week_count == 3) {

                $start_date = date('Y-m-d', strtotime("+2 week" , strtotime($start_month)));
                
                $end_date = date('Y-m-d', strtotime("+3 week" , strtotime($start_month)));

                $voucher_lists = Voucher::whereBetween('voucher_date', [$start_date, $end_date])->get();

            } else {

                $start_date = date('Y-m-d', strtotime("+3 week" , strtotime($start_month)));
                
                $end_date = date('Y-m-d',strtotime('last day of this month'));

                $voucher_lists = Voucher::whereBetween('voucher_date', [$start_date, $end_date])->get();
            }

        }
        else{

            $monthly = $request->value;

            $voucher_lists = Voucher::whereMonth('voucher_date', $monthly)->get();
        }

        foreach ($voucher_lists as $lists) {

            $total_sales += $lists->total_price;

            foreach ($lists->counting_unit as $unit) {

                $total_profit += ($unit->pivot->price * $unit->pivot->quantity) - ($unit->purchase_price * $unit->pivot->quantity);  
            }

        }

        return response()->json([
            "total_sales" => $total_sales,
            "total_profit" => $total_profit,
            "voucher_lists" => $voucher_lists,
        ]);
    }
    
    protected function changeCustomerPassword(Request $request){

    	$validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'new_password' => 'required',
        ]);

        if ($validator->fails()) {

        	return $this->sendFailResponse("Something Wrong! Validation Error.", "400");
        }

        $user = User::find($request->user_id);
            
        // $current_pw = $request->current_password;

        // if(!\Hash::check($current_pw, $user->password)){

        //     return $this->sendFailResponse("Something Wrong! Password doesn't match.", "400");
        // }

        $has_new_pw = \Hash::make($request->new_password);

        $user->password = $has_new_pw;

        $user->save();

        return response()->json([
                "user_code"=> $user->user_code,
            ]);
    }
}
