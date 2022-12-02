<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Tell the browser to be responsive to screen width -->
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    
    <title>@yield('title')</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    

    <link href="{{asset('assets/plugins/c3-master/c3.min.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{asset('css/colors/blue.css')}}" id="theme" rel="stylesheet">

    <link href="{{asset('assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="{{asset('assets/plugins/dropify/dist/css/dropify.min.css')}}">
    
    <link rel="stylesheet" href="{{asset('js/dist/css/qrcode-reader.min.css')}}">

    <link href="{{asset('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">

    <script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
</head>

<body class="fix-header fix-sidebar card-no-border logo-center">


    @include('sweet::alert')

    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
              
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
    
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        
                            <h2 class="text-white font-weight-bold font-italic"> Mya Swan Thar</h2>
                            
                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-message"></i>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox scale-up">
                                <ul>
                                    <li>
                                        <div class="drop-title">@lang('lang.notifications')</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Stock Check<span class="badge badge-danger float-right" id="stockNoti"></span></h5>
                                                    <small>Updated Item</small>
                                                </div>
                                            </a>
                                            
                                            <a href="#">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Voucher<span class="badge badge-danger float-right" id="stockNoti"></span></h5>
                                                    <small>Check Voucher</small>
                                                </div>
                                            </a>
                                            
                                            <a href="#">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Reorder<span class="badge badge-danger float-right" id="stockNoti"></span></h5>
                                                    <small>Check Reorder Item</small>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                </u
                                l>
                            </div>
                        </li>




                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{asset('image/user.jpg')}}" alt="user" class="profile-pic" />
                            </a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="{{asset('image/user.jpg')}}" alt="user"></div>
                                            <div class="u-text">
                                                <h4>{{session()->get('user')->name}}</h4>
                                                <p class="text-muted">{{session()->get('user')->email}}</p>
                                                <a href="#" class="btn btn-rounded btn-danger btn-sm">View Profile</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{route('change_password_ui')}}"><i class="mdi mdi-account-key"></i> Change Password </a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{route('logoutprocess')}}"><i class="mdi mdi-power"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                           

                            <a href="{{ url()->previous() }}" class="nav-link waves-effect waves-dark pt-2"><i class="fa fa-arrow-left"></i> Back</a>                            
                        </li>                        
                    </ul>

                    <div class="dropdown">
                      <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      @foreach (Config::get('languages') as $lang => $language)
                            @if ($lang == App::getLocale())
                                  {{$language}}
                            @endif
                      @endforeach
                      </a>
                
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                      @foreach (Config::get('languages') as $lang => $language)
                            @if ($lang != App::getLocale())
                                  <a class="dropdown-item english" href="{{url('localization/'.$lang)}}">{{$language}}</a>
                            @endif
                      @endforeach
                      </div>
                    </div>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
        
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        @if(session()->get('user')->role == "Owner")
                        <li>
                            <a href="{{route('index')}}">
                                <i class="mdi mdi-home"></i>
                                <span>@lang('lang.home')</span>
                            </a>
                        </li>
                        <li>
                            <a class="has-arrow " href="#" aria-expanded="false">
                                <i class="mdi mdi-store"></i>
                                <span class="hide-menu">
                                    @lang('lang.inventory')
                                </span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                
                                <li><a href="{{route('inven_dashboard')}}">@lang('lang.inventory_dashboard')</a></li>
                                <li><a href="{{route('category_list')}}">@lang('lang.category') @lang('lang.list')</a></li>
                                <li><a href="{{route('subcategory_list')}}">@lang('lang.subcategory') @lang('lang.list')</a></li>
                                <li><a href="{{route('item_list')}}">@lang('lang.item') @lang('lang.list')</a></li>
                                   
                            </ul>
                        </li>
                        <li>
                            <a class="has-arrow " href="#" aria-expanded="false">
                                <i class="mdi mdi-cart"></i>
                                <span class="hide-menu">
                                    @lang('lang.stock')
                                </span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                
                                <li><a href="{{route('stock_dashboard')}}">@lang('lang.stock_panel')</a></li>
                                <li><a href="{{route('stock_count')}}">@lang('lang.stock_count')</a></li>
                                <li><a href="{{route('stock_price_page')}}">@lang('lang.stock_price')</a></li>
                                <li><a href="{{route('stock_reorder_page')}}">@lang('lang.reorder_item')</a></li>
                                   
                            </ul>
                        </li>
                        @endif
                        <li>
                            <a class="has-arrow " href="#" aria-expanded="false">
                                <i class="mdi mdi-sale"></i>
                                <span class="hide-menu">
                                    @lang('lang.sales')
                                </span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                
                                <li><a href="{{route('sale_panel')}}">@lang('lang.sales') @lang('lang.panel')</a></li>
                                <li><a href="{{route('sale_page')}}">@lang('lang.sale')</a></li>
                                @if(session()->get('user')->role == "Owner")
                                <li><a href="{{route('sale_history')}}">@lang('lang.sale_history')</a></li>
                                @endif
                            </ul>
                        </li>
                       
                        @if(session()->get('user')->role == "Owner")
                        <li>
                            <a class="has-arrow " href="#" aria-expanded="false">
                                <i class="mdi mdi-clipboard-text"></i>
                                <span class="hide-menu">
                                    @lang('lang.order_list')
                                </span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{route('order_panel')}}">@lang('lang.order_panel')</a></li>                                
                                <li><a href="{{route('order_page','1')}}">@lang('lang.incoming_order')</a></li>
                                <li><a href="{{route('order_page','2')}}">@lang('lang.confirm_order')</a></li>
                                <li><a href="{{route('order_page','3')}}">@lang('lang.changes_order')</a></li>
                                <li><a href="{{route('order_page','4')}}">@lang('lang.delivered_order')</a></li>
                                <li><a href="{{route('order_page','5')}}">@lang('lang.accepted_order')</a></li>
                                <li><a href="{{route('order_history')}}">@lang('lang.order_voucher_history')</a></li>                                    
                            </ul>
                        </li>

                        <li>
                            <a class="has-arrow " href="#" aria-expanded="false">
                                <i class="mdi mdi-account-multiple-outline"></i>
                                <span class="hide-menu">
                                    @lang('lang.admin')
                                </span>
                            </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{route('admin_dashboard')}}">@lang('lang.admin') @lang('lang.panel')</a></li>
                                <li><a href="{{route('financial')}}">@lang('lang.financial')</a></li>
                                <li><a href="{{route('employee_list')}}">@lang('lang.employee') @lang('lang.list')</a></li>
                                <li><a href="{{route('customer_list')}}">@lang('lang.customer') @lang('lang.list')</a></li>
                                <li><a href="{{route('purchase_list')}}">@lang('lang.purchase') @lang('lang.list')</a></li>
                                <li><a href="{{route('expenses')}}">@lang('lang.expenses') @lang('lang.list')</a></li>
                            </ul>
                        </li>
                        @endif
                        <li>
                            <a href="{{route('logoutprocess')}}"><i class="mdi mdi-power"></i> <span>@lang('lang.logout')</span></a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
        
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">

                <div class="row page-titles">
                    
                    @yield('place')

                    <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-t-10 justify-content-end">
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>Today Sale</small></h6>
                                    <h4 class="m-t-0 text-info">{{number_format(session()->get('today_sale')) }} MMK</h4></div>
                                <div class="spark-chart">
                                    <div id="monthchart"></div>
                                </div>
                            </div>
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>Yesterday Sale</small></h6>
                                    <h4 class="m-t-0 text-primary">{{number_format(session()->get('last_day_sale')) }} MMK</h4></div>
                                <div class="spark-chart">
                                    <div id="lastmonthchart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @yield('content')

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer"> © 2020 KwinTechnology  Co.td </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('assets/plugins/popper/popper.min.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{asset('js/jquery.slimscroll.js')}}"></script>
    <!--Wave Effects -->
    <script src="{{asset('js/waves.js')}}"></script>
    <!--Menu sidebar -->
    <script src="{{asset('js/sidebarmenu.js')}}"></script>
    <!--stickey kit -->
    <script src="{{asset('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js')}}"></script>
    <script src="{{asset('assets/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('assets/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
    <!--Custom JavaScript -->
    <script src="{{asset('js/custom.min.js')}}"></script>

    <!--c3 JavaScript -->
    <script src="{{asset('assets/plugins/d3/d3.min.js')}}"></script>
    
    <script src="{{asset('assets/plugins/c3-master/c3.min.js')}}"></script>

    <script src="{{asset('assets/plugins/dropify/dist/js/dropify.min.js')}}"></script>
    
    <script src="{{asset('assets/plugins/popper/popper.min.js')}}"></script>
    
    <script src="{{asset('assets/plugins/multiselect/js/jquery.multi-select.js')}}" type="text/javascript"></script>
    
    <script src="{{asset('assets/plugins/select2/dist/js/select2.full.min.js')}}" type="text/javascript"></script>
    
    <script src="{{asset('js/validation.js')}}"></script>
    
    <script src="{{ asset('js/dist/js/qrcode-reader.min.js')}}"></script>

    <script src="{{asset('assets/plugins/moment/moment.js')}}"></script>

    <script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>

    <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

    @yield('js')

    
    
</body>

</html>
