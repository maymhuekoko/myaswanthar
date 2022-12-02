@extends('master')

@section('title','Reorder Page')

@section('place')

<div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.reorder_item')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">@lang('lang.reorder_item')</li>
    </ol>
</div>

@endsection

@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">        
        <h2 class="font-weight-bold">@lang('lang.reorder_item')</h2>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">

        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">@lang('lang.reorder_unit_list')</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>@lang('lang.category') @lang('lang.name')</th>
                                <th>@lang('lang.item') @lang('lang.name')</th>
                                <th>@lang('lang.unit') @lang('lang.name')</th>
                                <th>@lang('lang.unit') @lang('lang.current') @lang('lang.quantity')</th>
                                <th>@lang('lang.unit_reorder_quantity')</th>
                                <th class="text-center">@lang('lang.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($count_units as $unit)
                        	<tr>
                        		<td>{{$unit->item->category->category_name}}</td>
                        		<td>{{$unit->item->item_name}}</td>
                        		<td>{{$unit->unit_name}}</td>
                        		<td>{{$unit->current_quantity}}</td>
                        		<td>{{$unit->reorder_quantity}}</td>
                        		<td><a href="" class="">View Details</a></td>
                        	</tr>
                     		@endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>        
    </div>
    
</div>


@endsection