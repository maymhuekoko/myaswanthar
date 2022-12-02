 @extends('master')

@section('title','Voucher Page')

@section('place')

<div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">Sale Page</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">Back to Dashborad</a></li>
        <li class="breadcrumb-item active">Sale Page</li>
    </ol>
</div>

@endsection

@section('content')

<style>
    
    h6{
        font-size:15px;
        font-weight:600;
        line-height: 80%;
        letter-spacing: -1px;
    }
  }
</style>

<div class="row">
    <div class="card col-md-9">
        <div class="card-body">
            <ul class="nav nav-pills m-t-30 m-b-30">
                <li class="nav-item"> 
                    <a href="#navpills-2" class="nav-link active" data-toggle="tab" aria-expanded="false">
                        Option One
                    </a> 
                </li>
                <li class=" nav-item"> 
                    <a href="#navpills-1" class="nav-link" data-toggle="tab" aria-expanded="false">
                        Option Two
                    </a> 
                </li>
            </ul><br/>
            <div class="tab-content br-n pn">
                <div id="navpills-1" class="tab-pane">
                    <div class="row justify-content-center">
                        <div class="col-md-5 printableArea" style="width:45%;">
                            <div class="card card-body">
                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="text-center">
                                            <address>
                                                <h5> &nbsp;<b class="text-center">မြစွမ်းသာ</b></h5>
                                                    <h6>No.(827/A) Zayar Street, Ward(43)</h6>
                                                    <h6>North Dagon Township, Yangon</h6>
                                                    <h6><i class="fas fa-mobile-alt"></i>09450026996,09797377539,09764235538</h6>
                                            </address>
                                        </div>

                                        <div class="pull-right text-left">
                                            <h6>Date : <i class="fa fa-calendar"></i> {{$today_date}}</h6>
                                            <h6>Voucher Number : {{$voucher_code}}</h6>
                                        </div>

                                    </div>

                                    <div class="col-md-12">
                                        <div class="table-responsive" style="clear: both;">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Price*Qty</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($items as $item)
                                                    <tr>
                                                        <td style="font-size:15px;">{{$item->item_name}}</td>
                                                        <td style="font-size:15px;">{{$item->selling_price}} * {{$item->order_qty}} {{$item->unit_name}}</td>
                                                        <td style="font-size:15px;" id="subtotal">{{$item->selling_price * $item->order_qty}}</td>
                                                    </tr> 
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-right" style="font-size:18px;">Total</td>
                                                        <td id="total_charges" class="font-weight-bold" style="font-size:18px;"> {{$grand->sub_total}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-right" style="font-size:18px;">Pay</td>
                                                        <td id="pay" style="font-size:18px;"></td>
                                                        
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td class="text-right" style="font-size:18px;">Change</td>
                                                        <td id="changes" style="font-size:18px;"></td>
                                                    </tr>
                                                    
                                                </tfoot>    
                                            </table>
                                            <h6 class="text-center font-weight-bold">**ကျေးဇူးတင်ပါသည်***</h6>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div id="navpills-2" class="tab-pane active">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="card card-body printableArea">
                                <div style="display:flex;justify-content:space-around">
                                    <div>
                                        <img src="{{asset('image/myaswanthar.jpg')}}">
                                    </div>
                                    
                                    <div>
                                        <h3 class="mt-1 text-center"> &nbsp;<b style="font-size: 40px;">မြစွမ်းသာ</b></h3>
                    
                                        <p class="mt-2" style="font-size: 20px;" >No.(827/A), Zayar Street, Ward(43), North Dagon Township, Yangon
                                            <br/><i class="fas fa-mobile-alt"></i> 09-450026996,09-797377539,09-764235538
                                        </p>
                                    </div>
                                    
                                    <div></div>
                                </div>
                                
                                <div class="row">
                                    
                                    <div class="col-md-12">
                                        
                                        <h3 class="text-info mt-3" style="font-size : 25px"><b>@lang('lang.invoice') @lang('lang.number') :</b> {{$voucher_code}} </h3>
                                        
                                        <h3 class="text-info mt-2" style="font-size : 25px"><b>@lang('lang.invoice') @lang('lang.date') :</b> {{$today_date}} </h3>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <table style="width: 100%; ">
                                            <thead class="text-center">
                                                <tr>
                                                    <th style="font-size:30px; font-weight:bold; height: 15px; border: 2px solid black;">@lang('lang.number')</th>
                                                    <th style="font-size:30px; font-weight:bold; height: 15px; border: 2px solid black;">@lang('lang.item')</th>                                        
                                                    <th style="font-size:30px; font-weight:bold; height: 15px; border: 2px solid black;">@lang('lang.order_voucher_qty')</th>                                               
                                                    <th style="font-size:30px; font-weight:bold; height: 15px; border: 2px solid black;">@lang('lang.price')</th>
                                                    <th style="font-size:30px; font-weight:bold; height: 15px; border: 2px solid black;">@lang('lang.total')</th>
                        
                                                </tr>
                                            </thead>
                                                <tbody class="text-center">
                                                @php
                                                    $i = 1 ;
                                                @endphp 
                        
                                                @foreach($items as $unit)
                                                <tr> 
                                                    <td style="font-size:35px; font-weight:bold; height: 8px; border: 2px solid black;">{{$i++}}</td>
                                                    <td style="font-size:35px; font-weight:bold; height: 8px; border: 2px solid black;">{{$unit->item_name}}</td>
                                                    <td style="font-size:35px; font-weight:bold; height: 8px; border: 2px solid black;">{{$unit->order_qty}}</td>
                                                    <td style="font-size:35px; font-weight:bold; height: 8px; border: 2px solid black;">{{$unit->selling_price}}</td>
                                                    <td style="font-size:35px; font-weight:bold; height: 8px; border: 2px solid black;">{{$unit->selling_price * $unit->order_qty}}</td>   
                                                </tr> 
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <div class="row mt-2">
                                    
                                    <div class="col-md-6">
                                        <h3 class="text-info font-weight-bold" style="font-size:35px;"  >
                                            Name -  <span id="cus_name">  </span>
                                        </h3>
                                    </div>
                                    
                                    <div class="col-md-6 text-right">
                                        <h3 class="text-info font-weight-bold" style="font-size:35px;" >
                                            @lang('lang.total') -  <span id="total_charges"> {{$grand->sub_total}} </span>
                                        </h3>
                                    </div>
                                   
                                    <div class="col-md-6">
                                        <h3 class="text-info font-weight-bold" style="font-size:35px;" >
                                            Phone -  <span id="cus_phone">  </span>
                                        </h3>
                                    </div>
                                    
                                    <div class="col-md-6 text-right">
                                        <h3 class="text-info font-weight-bold" style="font-size:35px;">
                                            Pay -  <span id="pay_1">  </span>
                                        </h3>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <h3 class="text-info font-weight-bold" style="font-size:35px;" >
                                            Credit -  <span id="credit_amount">  </span>
                                        </h3>
                                    </div>
                                    
                                    <div class="col-md-6 text-right">
                                        <h3 class="text-info font-weight-bold" style="font-size:35px;">
                                            Change -  <span id="changes_1">  </span>
                                        </h3>
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


    <div class="col-md-3">
        <div class="row">
            <div class="col-md-12">
                <label class="control-label">Enter Customer Name</label>
                <select class="form-control" id="salescustomer_list" onchange="fillCustomer(this.value)">
                    <option value="">Select Customers</option>
                    @foreach($salescustomers as $salescustomer)
                        <option value="{{$salescustomer->id}}">{{$salescustomer->name}}</option>
                        @endforeach
                </select>
                <input type="text" class="form-control" id="name">
                
            </div>
            <div class="col-md-12">
                <label class="control-label">Enter Customer Phone</label>
                <input type="number" class="form-control" id="phone">
                
            </div>
            <div class="col-md-12">
                <label class="control-label">Enter Credit Amount</label>
                <input type="number" class="form-control" id="credit" > 
            </div>
            <br/>
            <br/>
            <div class="col-md-12">
                <button id="save" class="btn btn-info" type="button"><span><i class="fa fa-save"></i>Save Customer</span></button>
            </div>
            
            <div class="col-md-12">
                <label class="control-label">Enter Customer Pay </label>
                <label class="control-label" style="font-size:17px; font-weight:bold; height: 5px;">(Voucher Total: {{$grand->sub_total}} MMK) </label>
                <input type="number" class="form-control" id="payable"> 
            </div>
        </div><br/>
        <div class="row">
            <div class="col-md-6">
                <button id="print" class="btn btn-info" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
            </div>
            <div class="col-md-6">
                <button id="store_voucher" class="btn btn-info" type="button"> <span><i class="fa fa-calendar-check"></i> Store Voucher</span> </button>
            </div>
            <div class="col-md-6 mt-2">
                <a href="{{route('sale_page')}}" class="btn btn-danger">Return to Sale Page</a>
            </div>
        </div>
    </div>
    
</div>

                   

@endsection

@section('js')

<script src="{{asset('js/jquery.PrintArea.js')}}" type="text/JavaScript"></script>

<script type="text/javascript">

    var salescustomer = null;

    $(document).ready(function(){
       $(".select2").select2(); 
       //getCustomers();
    });
    
    function getCustomers(){

        $.ajax({

            type:'POST',

            url:'{{route('AjaxGetCustomerList')}}',

            data:{
                "_token":"{{csrf_token()}}",
            },

            success:function(data){
                salescustomer = data;

                $('#salescustomer_list').empty();             

                $('#salescustomer_list').append($('<option>').text("Select Customers").attr('value', ""));
                         
                $.each(data, function(i, value) {

                $('#salescustomer_list').append($('<option>').text(value.name).attr('value',value.id));
             
                });         

            },
        });

    }

     function fillCustomer(value){

        
        var customer_id = value;
        
        
        $.ajax({
            type:'POST',
            url:'{{route('AjaxGetCustomerwID')}}',
            data:{
              "_token":"{{csrf_token()}}",
              "customer_id": customer_id,
            },
            success:function(data){
              $("#name").val(data.name);
              $("#phone").val(data.phone);
             $("#credit").val(data.credit_amount);
            },
        });
    }

    $("#save").click(function(){
       var name = $('#name').val();
       var phone = $('#phone').val();
       var credit_amount = $('#credit').val();
       $.ajax({
           type:'POST',
           url:'{{route('AjaxStoreCustomer')}}',
           data:{
               "_token":"{{csrf_token()}}",
               "name": name,
               "phone": phone,
               "credit_amount": credit_amount,
           },
           success:function(data){
               if(data.success == 1){
                   alert(data.message);
              
               }
           }
       });
       
    });

 
    $("#print").click(function() {

        var item = @json($items);

        var grand = @json($grand);

        var voucher_code = @json($voucher_code);

        var pay = $('#payable').val();
        
        var name = $('#name').val();
        
        var phone = $('#phone').val();
        
        var credit = $('#credit').val();

        var total_charges = parseInt($('#total_charges').text());

        var changes = pay - total_charges;
        
        var id = $('#salescustomer_list').children("option:selected").val();

        $("#changes").text(changes);
        
        $("#pay").text(pay);
        
        $("#changes_1").text(changes);
        
        $("#pay_1").text(pay);
        
        $("#cus_name").text(name);
        
        $("#cus_phone").text(phone);
        
        $("#credit_amount").text(credit);

        if(!pay){

            swal({
                icon: 'error',
                title: 'Check Customer Pay Again!',
                text: 'Customer Pay cannot be null!!!',
                footer: '<a href>Why do I have this issue?</a>'
            })
        }

        else if(pay < total_charges){

            swal({
                icon: 'error',
                title: 'Check Customer Pay Again!',
                text: 'Customer Pay must be greater than or equal Total Amount!!!',
                footer: '<a href>Why do I have this issue?</a>'
            })

        }

        else{

            $.ajax({
                type:'POST',
                url:'Voucher',
                dataType:'json',
                data:{ 
                  "_token": "{{ csrf_token() }}",
                  "item": item,
                  "grand": grand,
                  "voucher_code": voucher_code,
                  "sales_customer_id": id,
                  "sales_customer_name": name,
                  "credit_amount": credit,
                },

                success: function(){
                    var mode = 'iframe'; //popup
                    var close = mode == "popup";
                    var options = {
                        mode: mode,
                        popClose: close
                    };
                        
                    $(".tab-pane.active div.printableArea").printArea(options);   
                },            
            }); 

            localStorage.clear();           
        }    
    });

    $("#store_voucher").click(function(){

        var item = @json($items);

        var grand = @json($grand);

        var voucher_code = @json($voucher_code);

        var cus_pay = $('#payable').val();
    
        var total = parseInt($('#total_charges').text());
        
        var name = $('#name').val();
        
        var id = $('#salescustomer_list').children("option:selected").val();
        
        var credit = $('#credit').val();

        if(!cus_pay){

            swal({
                icon: 'error',
                title: 'Check Customer Pay Again!',
                text: 'Customer Pay cannot be null!!!',
                footer: '<a href>Why do I have this issue?</a>'
            })
        }
        else if(cus_pay < total){

            swal({
                icon: 'error',
                title: 'Check Customer Pay Again!',
                text: 'Customer Pay must be greater than or equal Total Amount!!!',
                footer: '<a href>Why do I have this issue?</a>'
            })

        }
        else{

            $.ajax({
                type:'POST',
                url:'Voucher',
                dataType:'json',
                data:{ 
                  "_token": "{{ csrf_token() }}",
                  "item": item,
                  "grand": grand,
                  "voucher_code": voucher_code,
                  "sales_customer_id": id,
                  "sales_customer_name":name,
                  "credit_amount": credit,
                },

                success: function(){
                    swal({
                        icon: 'success',
                        title: 'Successfully Stored Voucher!',
                        text: 'Voucher is Successfully stored!!!',
                    })

                    localStorage.clear();

                    setTimeout(function(){
                        window.location.href = "{{ route('sale_page')}}";
                    }, 1000);
                },            
            });
        }

    });

</script>

@endsection