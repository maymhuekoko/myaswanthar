<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('localization/{locale}','LocalizationController@index');

Route::get('/', 'Web\LoginController@index')->name('index');

Route::post('Authenticate', 'Web\LoginController@loginProcess')->name('loginProcess');

Route::get('LogoutProcess', 'Web\LoginController@logoutProcess')->name('logoutprocess');


Route::group(['middleware' => ['UserAuth']], function () { 

    Route::get('ChangePassword-UI', 'Web\LoginController@getChangePasswordPage')->name('change_password_ui');
    Route::put('UpdatePassword', 'Web\LoginController@updatePassword')->name('update_pw');

    //Dashboard List
    Route::get('Inventory-Dashboard', 'Web\InventoryController@getInventoryDashboard')->name('inven_dashboard');   	
    Route::get('Stock-Dashboard', 'Web\StockController@getStockPanel')->name('stock_dashboard');
    Route::get('Sale-Dashboard', 'Web\SaleController@getSalePanel')->name('sale_panel');
    Route::get('Order-Dashboard', 'Web\OrderController@getOrderPanel')->name('order_panel');
    Route::get('Admin-Dashboard','Web\AdminController@getAdminDashboard')->name('admin_dashboard');

    //Ajax List
    Route::post('AjaxGetItem', 'Web\InventoryController@AjaxGetItem')->name('AjaxGetItem');
    Route::post('AjaxGetCountingUnit', 'Web\InventoryController@AjaxGetCountingUnit')->name('AjaxGetCountingUnit');
    Route::post('getCountingUnitsByItemId', 'Web\SaleController@getCountingUnitsByItemId');
    Route::post('getCountingUnitsByItemCode', 'Web\SaleController@getCountingUnitsByItemCode');
    Route::post('getCustomerInfo', 'Web\AdminController@getCustomerInfo');
    Route::post('ajaxConvertResult', 'Web\InventoryController@ajaxConvertResult');
    Route::post('storeCustomerOrder', 'Web\OrderController@storeCustomerOrder');
    Route::post('getTotalSaleReport', 'Web\AdminController@getTotalSaleReport');
    Route::post('showSubCategory', 'Web\InventoryController@showSubCategory');
    Route::post('AjaxGetCustomerList','Web\AdminController@getSalesCustomerList')->name('AjaxGetCustomerList');
    Route::post('AjaxGetCustomerwID','Web\AdminController@getSalesCustomerWithID')->name('AjaxGetCustomerwID');
    Route::post('AjaxStoreCustomer','Web\AdminController@storeSalesCustomer')->name('AjaxStoreCustomer');
    Route::post('changeCustomerPassword', 'Web\AdminController@changeCustomerPassword');

    //Category
    Route::get('category', 'Web\InventoryController@categoryList')->name('category_list');
	Route::post('category/store', 'Web\InventoryController@storeCategory')->name('category_store');
	Route::post('category/update/{id}', 'Web\InventoryController@updateCategory')->name('category_update');
	Route::post('category/delete', 'Web\InventoryController@deleteCategory');
	
	//SubCategory
	Route::get('subcategory', 'Web\InventoryController@subcategoryList')->name('subcategory_list');
	Route::post('subcategory/store', 'Web\InventoryController@storeSubCategory')->name('sub_category_store');
	Route::post('subcategory/update/{id}', 'Web\InventoryController@updateSubCategory')->name('sub_category_update');
	

    //Item
	Route::get('item', 'Web\InventoryController@itemList')->name('item_list');
	Route::post('item/store', 'Web\InventoryController@storeItem')->name('item_store');
	Route::post('item/update/{id}', 'Web\InventoryController@updateItem')->name('item_update');
	Route::post('item/delete', 'Web\InventoryController@deleteItem');

    //Counting Unit
	Route::get('Count-Unit/{item_id}', 'Web\InventoryController@getUnitList')->name('count_unit_list');    
    Route::post('Count-Unit/store', 'Web\InventoryController@storeUnit')->name('count_unit_store');    
    Route::post('Count-Unit/update/{id}', 'Web\InventoryController@updateUnit')->name('count_unit_update');
    Route::post('Count-Unit/code_update/{id}', 'Web\InventoryController@updateUnitCode')->name('count_unit_code_update');
    Route::post('Count-Unit/original_code_update/{id}', 'Web\InventoryController@updateOriginalCode')->name('original_code_update');
    Route::post('Count-Unit/delete', 'Web\InventoryController@deleteUnit');

    //Counting Unit Relation
    Route::get('Unit-Relation/{item_id}', 'Web\InventoryController@unitRelationList')->name('unit_relation_list');
    Route::post('Unit-Relation/store', 'Web\InventoryController@storeUnitRelation')->name('unit_relation_store');
    Route::post('Unit-Relation/update/{id}', 'Web\InventoryController@updateUnitRelation')->name('unit_relation_update');
    
    //Counting Unit Conversion
    Route::get('Unit-Convert/{unit_id}', 'Web\InventoryController@convertUnit')->name('convert_unit');
    //Route::post('Unit-Convert/store', 'Web\InventoryController@convertCountUnit')->name('convert_count_unit');
    
    //StockCount
    Route::get('Stock-Count/Count', 'Web\StockController@getStockCountPage')->name('stock_count');
    Route::get('Stock-Count/Price', 'Web\StockController@getStockPricePage')->name('stock_price_page');
    Route::get('Stock-Count/Reorder', 'Web\StockController@getStockReorderPage')->name('stock_reorder_page');
    Route::post('Stock-Count/UpdateCount', 'Web\StockController@updateStockCount')->name('update_stock_count');
    Route::post('Stock-Count/UpdatePrice', 'Web\StockController@updateStockPrice')->name('update_stock_price');

    //Employee
    Route::get('Employee', 'Web\AdminController@getEmployeeList')->name('employee_list');
    Route::post('Employee/store', 'Web\AdminController@storeEmployee')->name('employee_store');
    Route::get('Employee/details/{id}', 'Web\AdminController@getEmployeeDetails')->name('employee_details');
    
    //Customer
    Route::get('Customer', 'Web\AdminController@getCustomerList')->name('customer_list');
    Route::post('Customer/store', 'Web\AdminController@storeCustomer')->name('store_customer');
    Route::get('Customer/details/{id}', 'Web\AdminController@getCustomerDetails')->name('customer_details');
    Route::post('Customer/update/{id}', 'Web\AdminController@updateCustomer')->name('customer_update');
    Route::post('Customer/Change-Level', 'Web\AdminController@changeCustomerLevel')->name('change_customer_level');

    //Sale
    Route::get('Sale', 'Web\SaleController@getSalePage')->name('sale_page');
    Route::post('Sale/Voucher', 'Web\SaleController@storeVoucher');
    Route::post('Sale/Get-Voucher', 'Web\SaleController@getVucherPage')->name('get_voucher');
    Route::get('Sale/History', 'Web\SaleController@getSaleHistoryPage')->name('sale_history');
    Route::get('Sale/SummaryMain','Web\SaleController@getVoucherSummaryMain')->name('voucher_summary_main');
    Route::post('Sale/SummaryDetail','Web\SaleController@searchItemSalesByDate')->name('search_item_sales_by_date');
    Route::post('Sale/Search-History', 'Web\SaleController@searchSaleHistory')->name('search_sale_history');
    Route::get('Sale/Voucher-Details/{id}', 'Web\SaleController@getVoucherDetails')->name('getVoucherDetails');
    
    //Order
    Route::get('Order/{type}', 'Web\OrderController@getOrderPage')->name('order_page');
    Route::get('Order-Details/{id}', 'Web\OrderController@getOrderDetailsPage')->name('order_details');
    Route::post('Order/Change', 'Web\OrderController@changeOrderStatus')->name('update_order_status');
    Route::get('Order/Voucher/History', 'Web\OrderController@getOrderHistoryPage')->name('order_history');
    Route::post('Order/Voucher/Search-History', 'Web\OrderController@searchOrderVoucherHistory')->name('search_order_history');
    Route::get('Order/Voucher-Details/{id}', 'Web\OrderController@getVoucherDetails')->name('voucher_order_details');
    
    //Purchase
    Route::get('Purchase', 'Web\AdminController@getPurchaseHistory')->name('purchase_list');
    Route::get('Purchase/Details/{id}', 'Web\AdminController@getPurchaseHistoryDetails')->name('purchase_details');
    Route::get('Purchase/Create', 'Web\AdminController@createPurchaseHistory')->name('create_purchase');
    Route::post('Purchase/Store', 'Web\AdminController@storePurchaseHistory')->name('store_purchase');
    
    //financial
    Route::get('Financial', 'Web\AdminController@getTotalSalenAndProfit')->name('financial');
    Route::get('Expenses', 'Web\AdminController@expenseList')->name('expenses');
    Route::post('storeExpense', 'Web\AdminController@storeExpense')->name('store_expense');
});