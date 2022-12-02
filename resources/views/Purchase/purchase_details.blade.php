@extends('master')

@section('title','Purchase Details')

@section('place')

<div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.purchase') @lang('lang.details')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">@lang('lang.purchase') @lang('lang.details')</li>
    </ol>
</div>

@endsection

@section('content')

<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">        
        <h2 class="font-weight-bold">@lang('lang.purchase') @lang('lang.details') @lang('lang.page')</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-14">
        <div class="card shadow">
            <div class="card-header">
                <h4 class="font-weight-bold mt-2">@lang('lang.purchase') @lang('lang.details')</h4>
            </div>
            <div class="card-body">
           	           	
            	<div class="row">
            		<div class="col-md-6">

            			<div class="row">				           
			              	<div class="font-weight-bold text-primary col-md-5">@lang('lang.purchase_date')</div>
			              	<h5 class="font-weight-bold col-md-4 mt-1">
			              		{{date('d-m-Y', strtotime($purchase->purchase_date))}}
			              	</h5>
				        </div> 

				        <div class="row mt-1">				           
			              	<div class="font-weight-bold text-primary col-md-5">@lang('lang.total') @lang('lang.price')</div>
			              	@php
			              	    $backup_total = 0;
			              	    $sub_total = 0;
			              	    foreach($purchase->counting_unit as $unit){
			              	        $sub_total = $unit->pivot->quantity * $unit->pivot->price;
			              	        $backup_total += $sub_total;
			              	    }
			              	@endphp
			              	<h5 class="font-weight-bold col-md-4 mt-1">{{($purchase->total_price==0)? $backup_total : $purchase->total_price}}</h5>
				        </div> 

				        <div class="row mt-1">				           
			              	<div class="font-weight-bold text-primary col-md-5">@lang('lang.total') @lang('lang.quantity')</div>
			              	<h5 class="font-weight-bold col-md-4 mt-1">{{$purchase->total_quantity}}</h5>
				        </div> 

				        <div class="row mt-1">				           
			              	<div class="font-weight-bold text-primary col-md-5">@lang('lang.supplier_name')</div>
			              	<h5 class="font-weight-bold col-md-4 mt-1">{{$purchase->supplier_name}}</h5>
				        </div> 

				        <div class="row mt-1">				           
			              	<div class="font-weight-bold text-primary col-md-5">@lang('lang.purchase_by')</div>
			              	<h5 class="font-weight-bold col-md-4 mt-1">Purchaser</h5>
				        </div>

            		</div>

            		<div class="col-md-7" style="margin-left:auto;margin-right:auto;">
            			<h4 class="font-weight-bold mt-2 text-primary text-center">@lang('lang.purchase_unit')</h4>
            			<div class="table-responsive">
		                    <table class="table" id="example23" >
		                        <thead>
		                            <tr>
		                                <th>@lang('lang.index')</th>
		                                <th>@lang('lang.item') @lang('lang.name')</th>
		                                <th>@lang('lang.unit')  @lang('lang.name')</th>
		                                <th>@lang('lang.purchase_qty')</th>
		                                <th>@lang('lang.purchase_price')</th>
		                                <th>@lang('lang.sub_total')</th>
		                            </tr>
		                        </thead>
		                        <tbody>
		                            @php
                                        $i = 1 ;
                                    @endphp
		                            @foreach($purchase->counting_unit as $unit)
		                                <tr>
		                                    <td>{{$i++}}</td>
		                                	<td>{{$unit->item->item_name}}</td>
		                                	<td>{{$unit->unit_name}}</td>
		                                	<td>{{$unit->pivot->quantity}}</td>			                                   
		                                	<td>{{$unit->pivot->price}}</td>
		                                	<td>{{$unit->pivot->quantity * $unit->pivot->price}}</td>
		                                </tr>                                   
		                            @endforeach
		                        </tbody>
		                    </table>
		                </div>
            		</div>

            	</div>                
            </div>
        </div>
    </div>
</div>

@endsection