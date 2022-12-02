@extends('master')

@section('title','Voucher Details')

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
    td{

        text-align:left;
        font-size:20px;
        font-weight:bold;
        overflow:hidden;
        white-space: nowrap; 
    }
    th{
        text-align:left;
        font-size:15px;
    }
    h6{
        font-size:15px;
        font-weight:600;
    }

    .btn {
    width: 130px;
    overflow: hidden;
    white-space: nowrap;
  }
</style>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-body printableArea">
            <div class="row">
                <div class="col-md-3 text-center">
                    <img src="{{asset('image/Shwe_Kyar_Phyu.png')}}">
                </div>
                <div class="col-md-8 text-center b">
                    <h3 class="mt-2"> &nbsp;<b style="font-size: 40px;">မြစွမ်းသာ</b> </h3>

                    <p class="mt-3" style="font-size: 15px;" > No.(827/A), Zayar Street, Ward(43), North Dagon Township, Yangon
                        <br/><i class="fas fa-mobile-alt"></i> 09-450026996,09-797377539,09-764235538 </p>
                </div>


                <div class="col-md-6 mt-2">
                    <h5 class="text-info ">
                        <b>@lang('lang.invoice') @lang('lang.date') :</b> 2{{date('d-m-Y', strtotime($voucher->voucher_date))}} 
                    </h5>
                </div>
                

                <div class="col-md-6 text-right pull-right">
                    <h5 class="text-info "><b>@lang('lang.invoice') @lang('lang.number') :</b> {{$voucher->voucher_code}} </h5>
                                    
                </div>
                <br>
                
                <div class="col-md-6 mt-2">
                    <h5 class="text-info "><b>Bill To: </b> {{($voucher->sales_customer_name!= "") ? $voucher->sales_customer_name : "Customer"}} </h5>
                                    
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr style="overflow:hidden;white-space: nowrap">
                                    <th>@lang('lang.number')</th>
                                    <th class="text-center">@lang('lang.item')</th>                                        
                                    <th>@lang('lang.quantity')</th>                                               
                                    <th>@lang('lang.sales') @lang('lang.price')</th>
                                    <th>@lang('lang.total')</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1 ;
                                @endphp 

                                @foreach($voucher->counting_unit as $unit)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$unit->item->item_name}}</td>
                                    <td>{{$unit->pivot->quantity}}</td>
                                    <td>{{$unit->pivot->price}}</td>
                                    <td>{{$unit->pivot->price * $unit->pivot->quantity}}</td>   
                                </tr> 
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="pull-right m-t-30 text-right">
                        <h2><b>@lang('lang.total') :</b> {{$voucher->total_price}} MMK</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-3 text-center">
        <button id="print" class="btn btn-outline-info" type="button"> 
            <span><i class="fa fa-print"></i>Print</span> 
        </button>
    </div>
</div>

@endsection

@section('js')

<script src="{{asset('js/jquery.PrintArea.js')}}" type="text/JavaScript"></script>

<script>
    $(document).ready(function() {
        $("#print").click(function() {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("div.printableArea").printArea(options);
        });
    });
    </script>


@endsection