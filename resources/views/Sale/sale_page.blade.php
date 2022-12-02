@extends('master')

@section('title','Sale Page')

@section('place')

<div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.sale')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">@lang('lang.sale')</li>
    </ol>
</div>

@endsection

@section('content')

<div class="row mb-3">
    
    <div class="col-md-4 col-xl-4">
        
        <label class="focus-label">@lang('lang.search_bar')</label>      
        <input class="form-control" type="text" onchange="QRcodeTest(this.value)" id="qr_code" autofocus>
        
    </div>

    <div class="col-md-3 col-xl-3">  
        <label class="focus-label">@lang('lang.select_price')</label>  
        <select id="price_type" class="form-control">
            <option value="1">Normal Sale Price</option>
            <option value="2">Whole Sale Sale Price</option>
            <option value="3">Customer Order Sale Price</option>
        </select>
        
    </div>

    <div class="col-md-2">
        <form action="{{route('get_voucher')}}" method="post" id="vourcher_page">
            @csrf
            <input type="hidden" id="item" name="item">
            
            <input type="hidden" id="grand" name="grand">
        </form> 
    </div>

    <div class="col-md-2 col-xl-2 mt-3 pb-2">

        <a href="#" class="btn btn-primary btn-rounded mt-3" onclick="qrSearch()"><i class="fa fa-check"></i> @lang('lang.scan_bar_code')</a>
        
    </div>
</div> 

<div class="row">

    <div class="card col-md-6">

        <ul class="nav nav-tabs customtab" role="tablist">
            <li class="nav-item"> 
                <a class="nav-link" data-toggle="tab" href="4" role="tab">
                    <span class="hidden-sm-up">
                        <i class="ti-home"></i>
                    </span> 
                    <span class="hidden-xs-down">
                        ALL
                    </span>
                </a> 
            </li>
            @foreach($categories as $category)
            <li class="nav-item"> 
                <a class="nav-link" data-toggle="tab" href="#{{$category->id}}" role="tab">
                    <span class="hidden-sm-up">
                        <i class="ti-home"></i>
                    </span> 
                    <span class="hidden-xs-down">
                        {{$category->category_name}}
                    </span>
                </a> 
            </li>
            @endforeach
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="4" role="tabpanel"><br>
                <div class="col-md-5">
                    <label class="control-label">SubCategory</label>
                    <select class="form-control" onchange="showItemforAll(this.value)">
                        <option value="">Select</option>
                        @foreach($sub_categories as $sub_category)
                        <option value="{{$sub_category->id}}">{{$sub_category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <table class="table" id="table_4">
                    <thead class="text-center">
                        <tr>
                            <th>@lang('lang.item') @lang('lang.code')</th>
                            <th>@lang('lang.item') @lang('lang.name')</th>
                            <th>@lang('lang.item_photo')</th>
                            <th>@lang('lang.action')</th>
                        </tr>
                    </thead>
                        <tbody class="text-center" id="all">
                            @foreach($items as $item)
                                <tr>
                                    <td>{{$item->item_code}}</td>
                                    <td>{{$item->item_name}}</td>
                                    <td>
                                        <img src="{{asset('/photo/Item/'. $item->photo_path)}}" class="img-rounded" width="100" height="70" />
                                    </td>
                                    <td class="text-center">
                                        <i class="btn btn-success" onclick="getCountingUnit({{$item->id}})"><i class="fas fa-plus"></i>@lang('lang.sale_button')</i>
                                    </td>                                    
                                </tr>
                            @endforeach
                        </tbody>
                </table>
            </div>
            <div class="tab-pane" id="1" role="tabpanel"><br>
                <div class="col-md-5">
                    <label class="control-label">SubCategory</label>
                    <select class="form-control" onchange="showItemForFrozen(this.value)">
                        <option value="">Select</option>
                        @foreach($sub_categories as $sub_category)
                            @if($sub_category->category_id == 1)
                                <option value="{{$sub_category->id}}">{{$sub_category->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <table class="table" id="table_1">
                    <thead class="text-center">
                        <tr>
                            <th>@lang('lang.item') @lang('lang.code')</th>
                            <th>@lang('lang.item') @lang('lang.name')</th>
                            <th>@lang('lang.item_photo')</th>
                            <th>@lang('lang.action')</th>
                        </tr>
                    </thead>
                        <tbody class="text-center" id="frozen">
                            @foreach($items as $item)
                                @if($item->category_id == 1)
                                <tr>
                                    <td>{{$item->item_code}}</td>
                                    <td>{{$item->item_name}}</td>
                                    <td>
                                        <img src="{{asset('/photo/Item/'. $item->photo_path)}}" class="img-rounded" width="100" height="70" />
                                    </td>
                                    <td class="text-center">
                                        <i class="btn btn-success" onclick="getCountingUnit({{$item->id}})"><i class="fas fa-plus"></i>@lang('lang.sale_button')</i>
                                    </td>                                    
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                </table>
            </div>
            <div class="tab-pane" id="2" role="tabpanel"><br>
                <div class="col-md-5">
                    <label class="control-label">SubCategory</label>
                    <select class="form-control" onchange="showItemForDry(this.value)">
                        <option value="">Select</option>
                        @foreach($sub_categories as $sub_category)
                            @if($sub_category->category_id == 2)
                                <option value="{{$sub_category->id}}">{{$sub_category->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <table class="table" id="table_2">
                    <thead class="text-center">
                        <tr>
                            <th>@lang('lang.item') @lang('lang.code')</th>
                            <th>@lang('lang.item') @lang('lang.name')</th>
                            <th>@lang('lang.item_photo')</th>
                            <th class="text-center">@lang('lang.action')</th>
                        </tr>
                    </thead>
                        <tbody class="text-center" id="dry">
                            @foreach($items as $item)
                                @if($item->category_id == 2)
                                <tr>
                                    <td>{{$item->item_code}}</td>
                                    <td>{{$item->item_name}}</td>
                                    <td>
                                        <img src="{{asset('/photo/Item/'. $item->photo_path)}}" class="img-rounded" width="100" height="70" />
                                    </td>
                                    <td class="text-center">
                                        <i class="btn btn-success" onclick="getCountingUnit({{$item->id}})"><i class="fas fa-plus"></i>@lang('lang.sale_button')</i>
                                    </td>                                    
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                </table>
            </div>

            <div class="tab-pane" id="3" role="tabpanel"><br>
                <div class="col-md-5">
                    <label class="control-label">SubCategory</label>
                    <select class="form-control" onchange="showItemForSea(this.value)">
                        <option value="">Select</option>
                        @foreach($sub_categories as $sub_category)
                             @if($sub_category->category_id == 3)
                                <option value="{{$sub_category->id}}">{{$sub_category->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <table class="table" id="table_3">
                    <thead class="text-center">
                        <tr>
                            <th>@lang('lang.item') @lang('lang.code')</th>
                            <th>@lang('lang.item') @lang('lang.name')</th>
                            <th>@lang('lang.item_photo')</th>
                            <th>@lang('lang.action')</th>
                        </tr>
                    </thead>
                        <tbody class="text-center" id="sea">
                            @foreach($items as $item)
                                @if($item->category_id == 3)
                                <tr>
                                    <td>{{$item->item_code}}</td>
                                    <td>{{$item->item_name}}</td>
                                    <td>
                                        <img src="{{asset('/photo/Item/'. $item->photo_path)}}" class="img-rounded" width="100" height="70" />
                                    </td>
                                    <td class="text-center">
                                        <i class="btn btn-success" onclick="getCountingUnit({{$item->id}})"><i class="fas fa-plus"></i>@lang('lang.sale_button')</i>
                                    </td>                                    
                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                </table>
            </div>

            <div class="modal fade" id="unit_table_modal" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">@lang('lang.unit_information')</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="#close_modal">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body" id="checkout_modal_body">                                           
                            <table class="table">
                                <thead>
                                    <tr class="text-center">
                                        <th>@lang('lang.item') @lang('lang.name')</th>
                                        <th>@lang('lang.unit') @lang('lang.name')</th>
                                        <th>@lang('lang.price')</th>
                                    </tr>
                                </thead>
                                <tbody id="count_unit">
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

	<div class="col-md-6">
		<div class="card">
			<div class="card-title">
				<a href="" class="float-right" onclick="deleteItems()">Refresh Here &nbsp<i class="fas fa-sync"></i></a>
			</div>
			<div class="card-body">
				<div class="row justify-content-center">					
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th class="font-weight-bold text-info">@lang('lang.item') @lang('lang.name')</th>
                                <th class="font-weight-bold text-info">@lang('lang.unit') @lang('lang.name')</th>
                                <th class="font-weight-bold text-info">@lang('lang.quantity')</th>
                                <th class="font-weight-bold text-info">@lang('lang.price')</th>
                            </tr>
                        </thead>
                        <tbody id="sale">
                           <tr class="text-center">

                           </tr>
                        </tbody>
                        <tfoot>
                            <tr class="text-center">
                                <td class="font-weight-bold text-info" colspan="3">@lang('lang.total') @lang('lang.quantity')</td>
                                <td class="font-weight-bold text-info" id="total_quantity">0</td>
                            </tr>
                            <tr class="text-center">
                                <td class="font-weight-bold text-info" colspan="3">@lang('lang.sub_total')</td>
                                <td class="font-weight-bold text-info" id="sub_total">0</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                 <div class="row ml-2 justify-content-center">

                    <div class="col-md-8">
                        <a href="#" class="btn btn-info" data-toggle="modal" data-target="#customer_order">
                            <i class="fas fa-calendar-check"></i> @lang('lang.add_customer_order') 
                        </a> 
                        
                        <i class="btn btn-success mr-2" onclick="showCheckOut()"><i class="fas fa-calendar-check"></i> @lang('lang.check_out') </i>

                         <div class="modal fade" id="customer_order" role="dialog" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">@lang('lang.add_customer_order')</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="form-group">    
                                            <label class="font-weight-bold">@lang('lang.select_customer')</label>
                                            <select class="form-control m-b-10" id="customer_id" style="width: 100%"  required onchange="getCustomerInfo(this.value)">
                                                @foreach($customers as $customer)
                                                <option value="{{$customer->id}}">{{$customer->user->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                         <div class="form-group">    
                                            <label class="font-weight-bold">@lang('lang.phone')</label>
                                            <input type="number" id="phone" class="form-control" required>
                                        </div>

                                        <div class="form-group">    
                                            <label class="font-weight-bold">@lang('lang.delivered_date')</label>
                                            <input type="datetime-local" id="delivered_date" class="form-control" required value="{{date('Y-m-d\TH:i', $today_date)}}">

                                         <div class="form-group">    
                                            <label class="font-weight-bold">@lang('lang.order_date')</label>
                                            <input type="date" id="order_date" class="form-control" required value="{{date('Y-m-d', $today_date)}}">
                                        </div>

                                        <div class="form-group">    
                                            <label class="font-weight-bold">@lang('lang.address')</label>
                                            <input type="text" id="address" class="form-control" required>

                                        </div>

                                        <div class="form-group">    
                                            <label class="font-weight-bold">Select Employee</label>
                                            <select class="form-control m-b-10" id="employee" style="width: 100%" required>
                                                <option value="">Please Choose Employee</option>
                                                @foreach($employees as $emp)
                                                    @if($emp->user->role == "Delivery_Person")
                                                <option value="{{$emp->id}}">{{$emp->user->name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>                                        

                                        <a href="#" class="btn btn-success" onclick="storeCustomerOrder()">
                                            <i class="fas fa-calendar-check"></i> @lang('lang.store_order')
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>                                   

                    </div>
                    
                </div>
			</div>
		</div>
	</div>
</div>



@endsection

@section('js')

<script type="text/javascript">

    $('#table_1').DataTable( {
    
        "paging":   false,
        "ordering": true,
        "info":     false,
        scrollY: 700,

    });

    $('#table_2').DataTable( {
    
        "paging":   false,
        "ordering": true,
        "info":     false,
        scrollY: 700,

    });

    $('#table_3').DataTable( {
    
        "paging":   false,
        "ordering": true,
        "info":     false,
        scrollY: 700,

    });
    $('#table_4').DataTable( {
    
        "paging":   false,
        "ordering": true,
        "info":     false,
        scrollY: 700,

    });

    $(document).ready(function() {
        
        showmodal();           

    });

	function deleteItems() {
        
      localStorage.clear();
    }

    function qrSearch(){

        document.getElementById("qr_code").focus();

    }

    function QRcodeTest(value){

        let sale_type = $("#price_type").val();
        
        $.ajax({

           type:'POST',

           url:'/getCountingUnitsByItemCode',
           
           data:{
            "_token":"{{csrf_token()}}",
            "unit_code":value,
           },

            success:function(data){

                var item_name = data.item.item_name;

                var id = data.id;

                var name = data.unit_name;

                var qty = parseInt(data.current_quantity);
        
                if (sale_type == 1) {
                 
                var price = data.normal_sale_price;

                } else if (sale_type == 2) {
                  
                var price = data.normal_sale_price;

                } else {
                 
                var price = data.order_price;

                }

                swal("Please Enter Quantity:", {
                    content: "input",
                })

                .then((value) => {
                    
                    
                    if (value.toString().match(/^\d+$/)){
                    if (value === qty ) {

                        swal({
                            title:"Can't Add",
                            text:"Your Input is higher than Current Quantity!",
                            icon:"info",
                        });

                    }else{

                        var total_price = price * value ;

                        var item={id:id,item_name:item_name,unit_name:name,current_qty:qty,order_qty:value,selling_price:price};
                    
                        var total_amount = {sub_total:total_price,total_qty:value};
                    
                        var mycart = localStorage.getItem('mycart');
                    
                        var grand_total = localStorage.getItem('grandTotal');

                        if(mycart == null ){
                        
                            mycart = '[]';

                            var mycartobj = JSON.parse(mycart);

                            mycartobj.push(item);

                            localStorage.setItem('mycart',JSON.stringify(mycartobj));
                        
                        }else{

                            var mycartobj = JSON.parse(mycart);
                        
                            var hasid = false;
                        
                            $.each(mycartobj,function(i,v){
                            
                                if(v.id == id ){

                                    hasid = true;

                                    v.order_qty = parseInt(value) + parseInt(v.order_qty);
                                }
                            })
                        
                            if(!hasid){

                                mycartobj.push(item);
                            }
                        
                            localStorage.setItem('mycart',JSON.stringify(mycartobj));
                        }
                        
                        if(grand_total == null ){
                            
                            localStorage.setItem('grandTotal',JSON.stringify(total_amount));
                            
                        }else{
                            
                            var grand_total_obj = JSON.parse(grand_total);
                            
                            grand_total_obj.sub_total = total_price + grand_total_obj.sub_total;
                            
                            grand_total_obj.total_qty = parseInt(value) + parseInt(grand_total_obj.total_qty);
                            
                            localStorage.setItem('grandTotal',JSON.stringify(grand_total_obj));
                        }
                        
                        showmodal();

                        $("#qr_code").val("");
                    }
                }else{
                    swal({
                            title:"Input Invalid",
                            text:"Please only type english digit for quantity!",
                            icon:"info",
                        });
                }  
                    
                })
            }

        });   
    }

    function getCountingUnit(item_id){

        var html = "";
        
        $.ajax({

           type:'POST',

           url:'/getCountingUnitsByItemId',
           
           data:{
            "_token":"{{csrf_token()}}",
            "item_id":item_id,
            
           },

            success:function(data){

                $.each(data, function(i, unit) {
                    
                    html+=`<tr class="text-center">
                            <input type="hidden" id="item_name" value="${unit.item.item_name}">
                            <input type="hidden" id="qty_${unit.id}" value="${unit.current_quantity}">
                            <td>${unit.item.item_name}</td>
                            <td id="name_${unit.id}">${unit.unit_name}</td>
                            <td><select class='form-control' id="price_${unit.id}"><option value='${unit.normal_sale_price}'>Normal Sale - ${unit.normal_sale_price}</option><option value='${unit.whole_sale_price}'>Whole Sale - ${unit.whole_sale_price}</option><option value='${unit.order_price}'>Order Sale - ${unit.order_price}</option></select></td>
                            
                            <td><i class="btn btn-primary" onclick="tgPanel(${unit.id})" ><i class="fas fa-plus"></i> Add</i></td>
                      </tr>`;
                });
                
                $("#count_unit").html(html);

                $("#unit_table_modal").modal('show');
            }

        });
    }

    function tgPanel(id){

        var item_name = $('#item_name').val();
            
        var item_price_check = $('#price_' + id).val();
        
        var name = $('#name_' + id).text();
        
        var qty_check = $('#qty_' + id).val();

        var qty = parseInt(qty_check);

        var price = parseInt(item_price_check);        
        
        if( item_price_check == ""){
            
            swal({
                title:"Please Check",
                text:"Please Select Price To Sell",
                icon:"info",
            });
        }
        else{

            swal("Please Enter Quantity:", {
                content: "input",
            })

            .then((value) => {
                if(value.toString().match(/^\d+$/)){
                if (value > qty ) {

                    swal({
                        title:"Can't Add",
                        text:"Your Input is higher than Current Quantity!",
                        icon:"info",
                    });

                }else{

                    var total_price = price * value ;

                    var item={id:id,item_name:item_name,unit_name:name,current_qty:qty,order_qty:value,selling_price:price};
                
                    var total_amount = {sub_total:total_price,total_qty:value};
                
                    var mycart = localStorage.getItem('mycart');
                
                    var grand_total = localStorage.getItem('grandTotal');

                    //console.log(item);

                    if(mycart == null ){
                    
                        mycart = '[]';

                        var mycartobj = JSON.parse(mycart);

                        mycartobj.push(item);

                        localStorage.setItem('mycart',JSON.stringify(mycartobj));
                    
                    }else{

                        var mycartobj = JSON.parse(mycart);
                    
                        var hasid = false;
                    
                        $.each(mycartobj,function(i,v){
                        
                            if(v.id == id ){

                                hasid = true;

                                v.order_qty = parseInt(value) + parseInt(v.order_qty);
                            }
                        })
                    
                        if(!hasid){

                            mycartobj.push(item);
                        }
                    
                        localStorage.setItem('mycart',JSON.stringify(mycartobj));
                    }
                    
                    if(grand_total == null ){
                        
                        localStorage.setItem('grandTotal',JSON.stringify(total_amount));
                        
                    }else{
                        
                        var grand_total_obj = JSON.parse(grand_total);
                        
                        grand_total_obj.sub_total = total_price + grand_total_obj.sub_total;
                        
                        grand_total_obj.total_qty = parseInt(value) + parseInt(grand_total_obj.total_qty);
                        
                        localStorage.setItem('grandTotal',JSON.stringify(grand_total_obj));
                    }

                    $("#unit_table_modal").modal('hide');
                        
                    showmodal();
                }
                }else{
                    swal({
                        title:"Input Invalid",
                        text:"Please only input english digit",
                        icon:"info",
                    });
                }
            })
            
        }
    }

    function plus(id){

        count_change(id,'plus',1);
    }

	function minus(id){

        count_change(id,'minus',1);
    }
    
    function remove(id,qty){
        count_change(id,'remove',qty)
    }

    function count_change(id,action,qty){
                
        var grand_total = localStorage.getItem('grandTotal');
        
        var mycart=localStorage.getItem('mycart');
        
        var mycartobj=JSON.parse(mycart);
        
        var grand_total_obj = JSON.parse(grand_total);

        var item = mycartobj.filter(item =>item.id == id);
        
        if( action == 'plus'){

            if (item[0].order_qty == item[0].current_qty) {

                swal({
                    title:"Can't Add",
                    text:"Can't Added Anymore!",
                    icon:"info",
                });

                $('#btn_plus_' + item[0].id).attr('disabled', 'disabled');
            }

            else{

                item[0].order_qty++;
          
                grand_total_obj.sub_total += parseInt(item[0].selling_price);
                
                grand_total_obj.total_qty ++;

                localStorage.setItem('mycart',JSON.stringify(mycartobj));
            
                localStorage.setItem('grandTotal',JSON.stringify(grand_total_obj));
            
                count_item();

                showmodal();    

            }          
        }
        else if (action == 'minus') {

            if(item[0].order_qty == 1){
              
                //var ans=confirm('Are you sure');
                
                swal({
                    title: "Are you sure?",
                    text: "The item will be remove from cart list",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Yes',
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }).then(
                function(isConfirm){
                    if(isConfirm){
                
                    let item_cart = mycartobj.filter(item =>item.id !== id );

                    grand_total_obj.sub_total -= parseInt(item[0].selling_price);
            
                    grand_total_obj.total_qty -- ;

                    localStorage.setItem('mycart',JSON.stringify(item_cart));

                    localStorage.setItem('grandTotal',JSON.stringify(grand_total_obj));

                    count_item();

                    showmodal();
              
                }else{
                
                    item[0].order_qty;

                    localStorage.setItem('mycart',JSON.stringify(mycartobj));
            
                    localStorage.setItem('grandTotal',JSON.stringify(grand_total_obj));
            
                    count_item();

                    showmodal(); 
                }
            });
            
                
            
            }else{

                item[0].order_qty--;

                grand_total_obj.sub_total -= parseInt(item[0].selling_price);
            
                grand_total_obj.total_qty -- ;

                localStorage.setItem('mycart',JSON.stringify(mycartobj));
            
                localStorage.setItem('grandTotal',JSON.stringify(grand_total_obj));
            
                count_item();

                showmodal();
            }
        }else if(action == 'remove'){
            //var ans=confirm('Are you sure?');
            
            swal({
                    title: "Are you sure?",
                    text: "The item will be remove from cart list",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Yes',
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }).then(
                function(isConfirm){

                if (isConfirm){
                    let item_cart = mycartobj.filter(item =>item.id !== id );

                    grand_total_obj.sub_total = grand_total_obj.sub_total - (parseInt(item[0].selling_price) * qty);
            
                    grand_total_obj.total_qty = grand_total_obj.total_qty - qty ;

                    localStorage.setItem('mycart',JSON.stringify(item_cart));

                    localStorage.setItem('grandTotal',JSON.stringify(grand_total_obj));

                    count_item();

                    showmodal();

                } else {
                     item[0].order_qty;

                    localStorage.setItem('mycart',JSON.stringify(mycartobj));
            
                    localStorage.setItem('grandTotal',JSON.stringify(grand_total_obj));
            
                    count_item();

                    showmodal(); 
                }
            });
            
                // if(ans){
                    
                    
              
                // }else{
                
                   
                // }
        }
    }

    function showmodal(){
        
        var mycart = localStorage.getItem('mycart');
        
        var grandTotal = localStorage.getItem('grandTotal');
        
        var grandTotal_obj = JSON.parse(grandTotal);
        
        if(mycart){
            
            var mycartobj = JSON.parse(mycart);
          
            var html='';

            if(mycartobj.length>0){

                $.each(mycartobj,function(i,v){

                    var id=v.id;

                    var item=v.item_name;

                    var qty=v.order_qty;

                    var count_name = v.unit_name

                    html+=`<tr class="text-center">
                            <td class="text-success font-weight-bold">${item}</td>

                            <td class="text-success font-weight-bold">${count_name}</td>

                            <td>
                                <i class="fa fa-plus-circle btnplus" onclick="plus(${id})" id="${id}"></i>  
                                ${qty}  
                                <i class="fa fa-minus-circle btnminus"  onclick="minus(${id})" id="${id}"></i>
                            </td>

                            <td class="text-success font-weight-bold">${v.selling_price}</td>
                            <td><i class="fa fa-times" onclick="remove(${id},${qty})" id="${id}"></i> </td>
                            </tr>`;
                            
                });
            }

            $("#total_quantity").text(grandTotal_obj.total_qty);
          
            $("#sub_total").text(grandTotal_obj.sub_total);

            $("#sale").html(html);
            
            qrSearch();
        }
    }


    function count_item(){

        var mycart = localStorage.getItem('mycart');

        if(mycart){
            
            var mycartobj = JSON.parse(mycart);

            var total_count = 0;

            $.each(mycartobj,function(i,v){

                total_count+=v.order_qty;

            })

            $(".item_count_text").html(total_count);

        }else{

            $(".item_count_text").html(0);

        }
    }

    function showCheckOut(){
         
        var mycart = localStorage.getItem('mycart');
            
        var grand_total = localStorage.getItem('grandTotal');
        
        if(!mycart){
            
            swal({
                title:"Please Check",
                text:"Item Cannot be Empty to Check Out",
                icon:"info",
            });
            
        }else{

            $("#item").attr('value', mycart);

            $("#grand").attr('value', grand_total);

            $("#vourcher_page").submit();

        }
    }

    function getCustomerInfo(value){

        $.ajax({

            type:'POST',

            url:'/getCustomerInfo',
           
            data:{
                "_token":"{{csrf_token()}}",
                "customer_id":value,
            },

            success:function(data){

                $("#phone").val(data.phone);

                $("#address").val(data.address);
            },
        

        }); 
    }

    function storeCustomerOrder(){
         
        var item = localStorage.getItem('mycart');
            
        var grand_total = localStorage.getItem('grandTotal');

        var customer_id = $('#customer_id').val();

        var phone = $('#phone').val();

        var order_date = $('#order_date').val();

        var delivered_date = $('#delivered_date').val();

        var employee = $('#employee').val();

        var address = $('#address').val();

        if(!item || !grand_total){
            
            swal({
                title:"@lang('lang.please_check')",
                text:"@lang('lang.cannot_checkout')",
                icon:"info",
            });
            
        }else{

            $.ajax({

                type:'POST',

                url:'/storeCustomerOrder',
               
                data:{
                "_token":"{{csrf_token()}}",
                "item":item,
                "grand_total":grand_total,
                "customer_id":customer_id,
                "phone":phone,
                "address":address,
                "order_date":order_date,
                "delivered_date":delivered_date,
                "employee":employee,
                },

                success:function(data){

                    localStorage.clear();

                    swal({
                        title:"Success",
                        text:"Order is Successfully Stored",
                        icon:"success",
                    });

                    var url = '{{ route("voucher_order_details", ":order_id") }}';

                    url = url.replace(':order_id', data.id);

                    setTimeout(function(){
                        window.location.href= url;
                    }, 1000);
                },

                error:function(status) {
                    
                    swal({
                        title:"Something Wrong!",
                        text:"Something Wrong When Store Customer Order",
                        icon:"error",
                    });
                }
            });

        }
    }
    
    function showItemforAll(value){
        
        $('#all').empty();
        
        console.log(value);
        
        var sub_category_id = value;
        
        var items = @json($items);
        
        var html = "";
        
        console.log(items);
        
        $.each(items, function(i,v){
            
            if(v.sub_category_id == sub_category_id){
                
                var url = '{{asset('/photo/Item/'. ":photo_path")}}';

                    url = url.replace(':photo_path', v.photo_path);
                
                html += `
                        <tr>
                                    <td>${v.item_code}</td>
                                    <td>${v.item_name}</td>
                                    <td>
                                        <img src="${url}" class="img-rounded" width="100" height="70" />
                                    </td>
                                    <td class="text-center">
                                        <i class="btn btn-success" onclick="getCountingUnit(${v.id})"><i class="fas fa-plus"></i>@lang('lang.sale_button')</i>
                                    </td>                                    
                                </tr>`
                                
                $('#all').html(html);
            }
            
        });
    }
    
    function showItemForFrozen(value){
        
        $('#frozen').empty();
        
        console.log(value);
        
        var sub_category_id = value;
        
        var items = @json($items);
        
        var html = "";
        
        console.log(items);
        
        $.each(items, function(i,v){
            
            if(v.sub_category_id == sub_category_id){
                
                var url = '{{asset('/photo/Item/'. ":photo_path")}}';

                    url = url.replace(':photo_path', v.photo_path);
                
                html += `
                        <tr>
                                    <td>${v.item_code}</td>
                                    <td>${v.item_name}</td>
                                    <td>
                                        <img src="${url}" class="img-rounded" width="100" height="70" />
                                    </td>
                                    <td class="text-center">
                                        <i class="btn btn-success" onclick="getCountingUnit(${v.id})"><i class="fas fa-plus"></i>@lang('lang.sale_button')</i>
                                    </td>                                    
                                </tr>`
                                
                $('#frozen').html(html);
            }
            
        });
    }
    
    function showItemForDry(value){
        
        $('#dry').empty();
        
        console.log(value);
        
        var sub_category_id = value;
        
        var items = @json($items);
        
        var html = "";
        
        console.log(items);
        
        $.each(items, function(i,v){
            
            if(v.sub_category_id == sub_category_id){
                
                var url = '{{asset('/photo/Item/'. ":photo_path")}}';

                    url = url.replace(':photo_path', v.photo_path);
                
                html += `
                        <tr>
                                    <td>${v.item_code}</td>
                                    <td>${v.item_name}</td>
                                    <td>
                                        <img src="${url}" class="img-rounded" width="100" height="70" />
                                    </td>
                                    <td class="text-center">
                                        <i class="btn btn-success" onclick="getCountingUnit(${v.id})"><i class="fas fa-plus"></i>@lang('lang.sale_button')</i>
                                    </td>                                    
                                </tr>`
                                
                $('#dry').html(html);
            }
            
        });
    }
    
    function showItemForSea(value){
        
        $('#sea').empty();
        
        console.log(value);
        
        var sub_category_id = value;
        
        var items = @json($items);
        
        var html = "";
        
        console.log(items);
        
        $.each(items, function(i,v){
            
            if(v.sub_category_id == sub_category_id){
                
                var url = '{{asset('/photo/Item/'. ":photo_path")}}';

                    url = url.replace(':photo_path', v.photo_path);
                
                html += `
                        <tr>
                                    <td>${v.item_code}</td>
                                    <td>${v.item_name}</td>
                                    <td>
                                        <img src="${url}" class="img-rounded" width="100" height="70" />
                                    </td>
                                    <td class="text-center">
                                        <i class="btn btn-success" onclick="getCountingUnit(${v.id})"><i class="fas fa-plus"></i>@lang('lang.sale_button')</i>
                                    </td>                                    
                                </tr>`
                                
                $('#sea').html(html);
            }
            
        });
    }

    /*function removeProduct(productId){

        let storageProducts = JSON.parse(localStorage.getItem('mycart'));

        let products = storageProducts.filter(item =>item.id !== productId );

        localStorage.setItem('mycart', JSON.stringify(products));

        showmodal();
    }*/

</script>

@endsection