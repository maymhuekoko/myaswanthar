@extends('master')

@section('title','Create Purchase')

@section('place')

<div class="col-md-5 col-8 align-self-center">
    <h3 class="text-themecolor m-b-0 m-t-0">@lang('lang.purchase') @lang('lang.create')</h3>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('index')}}">@lang('lang.back_to_dashboard')</a></li>
        <li class="breadcrumb-item active">Create Purchase</li>
    </ol>
</div>

@endsection

@section('content')

<div class="row page-titles">
    <div class="col-md-5 col-8 align-self-center">        
        <h2 class="font-weight-bold">@lang('lang.purchase') @lang('lang.create')</h2>
    </div>
</div>

<div class="row">
    <div class="col-7">
        <div class="card shadow">
            <div class="card-body">
                <h4 class="card-title">@lang('lang.purchase') @lang('lang.create')</h4>

                <form class="form-material m-t-40" method="post" action="{{route('store_purchase')}}">
                    @csrf

                    <div class="form-group">    
                        <label class="font-weight-bold">@lang('lang.purchase_date')</label>
                        <input type="date" name="purchase_date" class="form-control"> 
                    </div>
                    
                    <div class="form-group">    
                        <label class="font-weight-bold">@lang('lang.supplier_name')</label>
                        <input type="text" name="supp_name" class="form-control" placeholder="Enter Supplier Name"> 
                    </div>

                    <div id="unit_place">
                        <label class="font-weight-bold">Units</label>

                    </div>                

                    <input type="submit" name="btnsubmit" class="btnsubmit float-right btn btn-primary" value="Save Unit">
                </form>
            </div>
        </div>
    </div>

    <div class="col-5">
        <div class="card shadow">
            <div class="form-group m-2">  
                <label class="font-weight-bold">@lang('lang.category')</label>  
                <select class="form-control select2 m-b-10" style="width: 100%" onchange="getItem(this.value)">
                    <option>Choose Category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id}}">{{$category->category_name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group m-2">  
                <label class="font-weight-bold">@lang('lang.item')</label>  
                <select class="form-control select2 m-b-10" style="width: 100%" onchange="getUnit(this.value)" id="item" disabled>
                   
                </select>
            </div>

            <div class="form-group m-2">  
                <label class="font-weight-bold">@lang('lang.counting_unit')</label>  
                <select class="form-control select2 m-b-10" style="width: 100%" id="unit" disabled>
                    
                </select>
            </div>

            <div class="form-group m-2">    
                <label class="font-weight-bold">@lang('lang.quantity')</label>
                <input type="number" id="qty" class="form-control" > 
            </div>

            <div class="form-group m-2">    
                <label class="font-weight-bold">@lang('lang.enter_purchase_price')</label>
                <input type="number" id="price" class="form-control"> 
            </div>

            <div class="form-actions m-2">
              <button type="submit" class="btn btn-success float-right" id="add"> 
                <i class="fa fa-check"> </i> @lang('lang.add')
            </button>
              
            </div>
                       
        </div>
    </div>
</div>
@endsection


@section('js')

<script type="text/javascript">

    $(document).ready(function(){

        $(".select2").select2();
    });

    function getItem(category_id){
        
        var app = @json($items);
        
        $('#item').empty();

        $('#item').append($('<option>').text('Please Select Item'));
    
        $.each(app, function(i, value) {

            if (value.category_id == category_id) {

                $('#item').append($('<option>').text(value.item_name).attr('value', value.id));

            }           
        });
        

        $( "#item" ).prop( "disabled", false );
        
    }

    function getUnit(item_id){
        
        var app = @json($units);
        
        $('#unit').empty();

        $('#unit').append($('<option>').text("Please Select Unit"));
    
        $.each(app, function(i, value) {

            if (value.item_id == item_id) {

                $('#unit').append($('<option>').text(value.unit_name).attr('value', value.id));

            }           
        });
        

        $( "#unit" ).prop( "disabled", false );
        
    }

    var count = 0

    $('#add').click(function(event){

        event.preventDefault();

        var html = "";
        
        count + 1;
   
        var price = $('#price').val();

        var qty = $('#qty').val();

        var unit_id = $('#unit').val();

        var unit_name = $('#unit option:selected').text();
        
        var item = $('#item option:selected').text();

        if($.trim(price) == '' || $.trim(qty) == '' || $.trim(unit_id) == '')
        {
            swal({

                title:"Failed!",
                text:"Please fill all basic unit field",
                icon:"info",
                timer: 3000,
            });
            
        }else{

            html+=`<div class="form-group" id="removeclass_${count}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" value="${item}" readonly>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="hidden" name="unit[]" value="${unit_id}">
                                    <input type="text" class="form-control" value="${unit_name}" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="price[]" value="${price}" readonly>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="qty[]" value="${qty}" readonly>
                                </div>
                            </div>

                            <div class="col-md-1">
                                <button class="btn-outline-danger" type="button" onclick="remove_education_fields(${count});"> 
                                    <i class="fa fa-minus"></i> 
                                </button>
                            </div>
                        </div>
                   </div>`

            $("#unit_place").append(html);   

            formClear(); 
        }   
    });

    function remove_education_fields(rid) {

        console.log(rid);
        
        $('#removeclass_' + rid).remove();
    }

    function formClear() {

        $('#item').empty();

        $('#unit').empty();

        $( "#item" ).prop( "disabled", true );

        $( "#unit" ).prop( "disabled", true );

        $("#qty").val("");

        $("#price").val("");   
    }

    
</script>


@endsection