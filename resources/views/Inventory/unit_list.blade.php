@extends('master')

@section('title','Counting Unit List')

@section('place')

<div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.branch')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">@lang('lang.counting_unit_list')</li>
    </ol>
</div>

@endsection

@section('content')

<style>
    .btn {
    width: 100px;
    overflow: hidden;
    white-space: nowrap;
  }
</style>

<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">        
        <h2 class="font-weight-bold">@lang('lang.counting_unit_list')</h2>
    </div>
</div>


<div class="row">
    <div class="col-md-9">
        <div class="card shadow">
            <div class="card-body">
                <h4 class="card-title">{{$item->item_name}}'s @lang('lang.unit') @lang('lang.list') </h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('lang.unit') @lang('lang.code')</th>
                                <th>@lang('lang.unit') @lang('lang.original_code')</th>
                                <th>@lang('lang.unit') @lang('lang.name')</th>
                                <th style="overflow:hidden;white-space: nowrap;">@lang('lang.current') @lang('lang.quantity')</th>
                                <th style="overflow:hidden;white-space: nowrap;">@lang('lang.reorder_quantity')</th>
                                <th style="overflow:hidden;white-space: nowrap;">@lang('lang.normal_sale_price')</th>
                                <th style="overflow:hidden;white-space: nowrap;">@lang('lang.whole_sale_price')</th>
                                <th style="overflow:hidden;white-space: nowrap;">@lang('lang.order_price')</th>
                                <th style="overflow:hidden;white-space: nowrap;">@lang('lang.purchase_price')</th>
                                <th class="text-center">@lang('lang.action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1;?>

                            @foreach($units as $unit)
                            <tr>
                                <td>{{$i++}}</td>

                                <td style="overflow:hidden;white-space: nowrap;">{{$unit->unit_code}}</td>
                                <td style="overflow:hidden;white-space: nowrap;">{{$unit->original_code}}</td>
                                <td style="overflow:hidden;white-space: nowrap;">{{$unit->unit_name}}</td>
                                <td>{{$unit->current_quantity}}</td>
                                <td>{{$unit->reorder_quantity}}</td>
                                <td>{{$unit->normal_sale_price}}</td>
                                <td>{{$unit->whole_sale_price}}</td>
                                <td>{{$unit->order_price}}</td>
                                <td>{{$unit->purchase_price}}</td>                              
                                <td style="text-overflow: ellipsis; white-space: nowrap;">
                                    <a href="#" class="btn btn-outline-info" data-toggle="modal" data-target="#unit_code{{$unit->id}}">
                                    @lang('lang.add_code')</a>

                                    <a href="#" class="btn btn-outline-info" data-toggle="modal" data-target="#original_code{{$unit->id}}">
                                    @lang('lang.add_original_code')</a>

                                    <a href="#" class="btn btn-outline-warning" data-toggle="modal" data-target="#edit_item{{$unit->id}}">
                                    @lang('lang.edit')</a>

                                    <a href="#" class="btn btn-outline-danger" onclick="ApproveLeave('{{$unit->id}}')">
                                        <i class="mdi mdi-delete"></i>
                                        @lang('lang.delete')
                                    </a>
                                </td>

                                <div class="modal fade" id="unit_code{{$unit->id}}" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('lang.unit_code_form')</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                    <div class="modal-body">
                                        <form class="form-material" method="post" action="{{route('count_unit_code_update',$unit->id)}}">
                                            @csrf
                                            
                                            <div class="row jusitify-content-center">
                                                <div class="form-group col-12">   
                                                    <label class="font-weight-bold">@lang('lang.unit') @lang('lang.code')</label>
                                                    <input type="text" name="code" class="form-control" value="{{$unit->unit_code}}"> 
                                                </div>
                                                
                                            </div>

                                            <input type="submit" name="btnsubmit" class="btnsubmit float-right btn btn-primary" value="@lang('lang.update_counting_unit')">
                                        </form>           
                                    </div>
                                   
                                  </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="original_code{{$unit->id}}" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('lang.original_code_form')</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                    <div class="modal-body">
                                        <form class="form-material" method="post" action="{{route('original_code_update',$unit->id)}}">
                                            @csrf
                                            
                                            <div class="row jusitify-content-center">
                                                <div class="form-group col-12">   
                                                    <label class="font-weight-bold">@lang('lang.unit') @lang('lang.original_code')</label>
                                                    <input type="text" name="code" class="form-control" value="{{$unit->original_code}}"> 
                                                </div>
                                                
                                            </div>

                                            <input type="submit" name="btnsubmit" class="btnsubmit float-right btn btn-primary" value="@lang('lang.update_counting_unit')">
                                        </form>           
                                    </div>
                                   
                                  </div>
                                    </div>
                                </div>
                                
                                <div class="modal fade" id="edit_item{{$unit->id}}" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">@lang('lang.edit_counting_unit_form')</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                    <div class="modal-body">
                                        <form class="form-material" method="post" action="{{route('count_unit_update',$unit->id)}}">
                                            @csrf
                                            
                                            <div class="row jusitify-content-center">
                                                <div class="form-group col-12">   
                                                    <label class="font-weight-bold">@lang('lang.unit') @lang('lang.name')</label>
                                                    <input type="text" name="name" class="form-control" value="{{$unit->unit_name}}"> 
                                                </div>
                                                
                                            </div>

                                            <input type="submit" name="btnsubmit" class="btnsubmit float-right btn btn-primary" value="@lang('lang.update_counting_unit')">
                                        </form>           
                                    </div>
                                   
                                  </div>
                                    </div>
                                </div>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="card-title">@lang('lang.unit_create_form')</h3>
                <form class="form-material m-t-40" method="post" action="{{route('count_unit_store')}}">
                    @csrf
                    <input type="hidden" value="{{$item->id}}" name="item_id">

                    <div class="form-group">    
                        <label class="font-weight-bold">@lang('lang.unit') @lang('lang.name')</label>
                        <input type="text" name="name" class="form-control" placeholder="@lang('lang.enter_unit_name')"> 
                    </div>
                    
                    <div class="form-group">    
                        <label class="font-weight-bold">@lang('lang.current') @lang('lang.quantity')</label>
                        <input type="number" name="current_qty" class="form-control" placeholder="@lang('lang.enter_current_quantity')"> 
                    </div>
                    
                    <div class="form-group">    
                        <label class="font-weight-bold">@lang('lang.reorder_quantity')</label>
                        <input type="number" name="reorder_qty" class="form-control" placeholder="@lang('lang.enter_reorder_quantity')"> 
                    </div>
                    
                    <div class="form-group">    
                        <label class="font-weight-bold">@lang('lang.purchase_price')</label>
                        <input type="number" name="purchase_price" class="form-control" placeholder="@lang('lang.enter_purchase_price')"> 
                    </div>
                    
                    <div class="form-group">    
                        <label class="font-weight-bold">@lang('lang.normal_sale_price')</label>
                        <input type="number" name="normal_price" class="form-control" placeholder="@lang('lang.enter_normal_sale_price')"> 
                    </div>

                    <div class="form-group">    
                        <label class="font-weight-bold">@lang('lang.whole_sale_price')</label>
                        <input type="number" name="whole_price" class="form-control" placeholder="@lang('lang.enter_whole_sale_price')"> 
                    </div>
                    
                    <div class="form-group">    
                        <label class="font-weight-bold">@lang('lang.customer_order_sale_price')</label>
                        <input type="number" name="order_price" class="form-control" placeholder="@lang('lang.enter_customer_order_sale_price')"> 
                    </div>

                    <input type="submit" name="btnsubmit" class="btnsubmit float-right btn btn-primary" value="@lang('lang.save')">
                </form>
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

    function ApproveLeave(value){

        var unit_id = value;

        swal({
            title: "@lang('lang.confirm')",
            icon:'warning',
            buttons: ["@lang('lang.no')", "@lang('lang.yes')"]
        })

      .then((isConfirm)=>{
        
        if(isConfirm){

          $.ajax({
              type:'POST',
                url:'delete',
                dataType:'json',
                data:{ 
                  "_token": "{{ csrf_token() }}",
                  "unit_id": unit_id,
                },

              success: function(){
                      
                      swal({
                            title: "@lang('lang.success')!",
                            text : "@lang('lang.successfully_deleted')!",
                            icon : "success",
                        });

                        setTimeout(function(){
               window.location.reload();
            }, 1000);

                        
                    },            
                });
        }
      });

    }

</script>
@endsection