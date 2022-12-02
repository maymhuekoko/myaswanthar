@extends('master')

@section('title','Stock Count')

@section('place')

<div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.stock_count')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">@lang('lang.stock_count')</li>
    </ol>
</div>

@endsection

@section('content')

<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">        
        <h2 class="font-weight-bold">@lang('lang.stock_count')</h2>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">               
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">@lang('lang.select_category')</label>
                            <select class="form-control select2" onchange="getItems(this.value)" id="category_list">
                                <option value="">@lang('lang.select')</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!--/span-->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">@lang('lang.select_item')</label>
                            <select class="form-control select2" disabled id="item_list">
                                <option value="">@lang('lang.select')</option>
                            </select>                            
                        </div>
                    </div>
                </div>

                <div class="row justify-content-end">
                    <button class="btn btn-success" onclick="checkUnit()"> 
                        <i class="fa fa-check"></i> @lang('lang.check_unit')
                    </button>
                </div>
    
            </div>        
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">

        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">@lang('lang.counting_unit') @lang('lang.list')</h4>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>@lang('lang.category') @lang('lang.name')</th>
                                <th>@lang('lang.item') @lang('lang.name')</th>
                                <th>@lang('lang.unit') @lang('lang.name')</th>
                                <th>@lang('lang.current') @lang('lang.quantity')</th>
                                <th>@lang('lang.reorder_quantity')</th>
                                <th>@lang('lang.action')</th>
                            </tr>
                        </thead>
                        <tbody id="units_table">
                            @foreach($units as $unit)
                            <tr>
                                <td>{{$unit->item->category->category_name}}</td>
                                <td>{{$unit->item->item_name}}</td>
                                <td>{{$unit->unit_name}}</td>
                                <td>{{$unit->current_quantity}}</td>
                                <td>{{$unit->reorder_quantity}}</td>
                                <td> 
                                    <a href="#" class="btn btn-outline-warning" onclick="getModal({{$unit->id}})">
                                        @lang('lang.update')
                                    </a>
                                </td>
                            </tr>
                            @endforeach

                            <div class="modal fade" id="edit_unit_qty" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">@lang('lang.update_counting_unit_quantity') @lang('lang.form')</h4>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                        </div>

                                        <div class="modal-body">
                                            <form class="form-horizontal m-t-40" method="post" action="{{route('update_stock_count')}}">
                                                @csrf
                                                <input type="hidden" name="unit_id" id="unit_id">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-6">@lang('lang.counting_unit') @lang('lang.quantity')</label>
                                                    <div class="col-md-6">
                                                        <input type="number" class="form-control" name="quantity"> 
                                                        
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-6">@lang('lang.reorder_level')</label>
                                                    <div class="col-md-6">
                                                        <input type="number" class="form-control" name="reorder"> 
                                                        
                                                    </div>
                                                </div>

                                                <input type="submit" name="btnsubmit" class="btnsubmit float-right btn btn-primary" value="@lang('lang.save')">
                                            </form>           
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>        
    </div>
</div>
@endsection

@section('js')

<script>

    $(document).ready(function(){

        $(".select2").select2();
    });

    function getItems(value){

        var category_id = value;

        $('#item_list').prop("disabled", false);

        $.ajax({

            type:'POST',

            url:'{{route('AjaxGetItem')}}',

            data:{
                "_token":"{{csrf_token()}}",
                "category": category_id,           
            },

            success:function(data){

                $('#item_list').empty();             

                $('#item_list').append($('<option>').text("Select Item").attr('value', ""));
                         
                $.each(data, function(i, value) {

                $('#item_list').append($('<option>').text(value.item_name).attr('value', value.id));
             
                });         

            },
        });

    }

    function checkUnit(){

        let category = $('#category_list').val();

        let item = $('#item_list').val();

        $('#units_table').empty();

        $.ajax({

            type:'POST',

            url:'{{route('AjaxGetCountingUnit')}}',

            data:{
                "_token":"{{csrf_token()}}",
                "item": item,
            },

            success:function(data){

                $.each(data , function(i, value) {

                    let button = `<a  href="#" class="btn btn-outline-warning" onclick="getModal(${value.id})">Edit</a>`;

                    $('#units_table').append($('<tr>')).append($('<td>').text(value.item.category.category_name)).append($('<td>').text(value.item.item_name)).append($('<td>').text(value.unit_name)).append($('<td>').text(value.current_quantity)).append($('<td>').text(value.reorder_quantity)).append($('<td>').append($(button)));
                });


                
            },
        });

    }

    function getModal(value){

        event.preventDefault()

        $("#edit_unit_qty").modal("show");

        $("#unit_id").attr('value', value);
    }


</script>
@endsection