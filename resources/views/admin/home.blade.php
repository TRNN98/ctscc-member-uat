<!doctype html>
<html class="no-js" lang="en">

<head>
    @include('admin.layout.head')
</head>

<body class="materialdesign">
    <div class="wrapper-pro">

        <!-- Sidebar Start -->
        <div class="left-sidebar-pro">
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h3> {{ Auth::user()->username }} </h3>
                    <p> <?php
                            $logon = new LOGON_DETAIL();
                            $logon->identify =  session('username');
                            $last_logon = $logon->get_last_logon();
                            echo $last_logon[0]->access_date;
                        ?>
                    </p>
                    <!-- <strong>AP+</strong> -->
                </div>
                <!-- Menu Left Start -->
                <div class="left-custom-menu-adp-wrap animated flipInX">
                    {{-- DELETE class message-menu for tag ul  by boy --}}
                    <ul class="nav navbar-nav left-sidebar-menu-pro message-menu" style="margin-top: 28px;">
                        @if (request()->query('type') == 'M')
                            @foreach ($gtype[0] as $key => $head)
                                <li class="nav-item">
                                    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><span class="mini-dn">{{ $head->manu_name }}</span> <span class="indicator-right-menu mini-dn"><i class="fa indicator-mn fa-angle-left"></i></span></a>
                                    <div role="menu" class="dropdown-menu left-menu-dropdown animated flipInX">
                                        @foreach ($gtype[1][$key] as $pages)
                                            @if($pages->hyper_link != '')
                                            <a href="{{ url('admin/control').$pages->hyper_link }}" class="dropdown-item">
                                                @if (strlen($pages->description) > 75)
                                                    {{ mb_substr($pages->description,0,23) }} <br>
                                                    {{ mb_substr($pages->description,23) }}
                                                @else
                                                    {{  $pages->description }}
                                                @endif
                                            </a>
                                            @else
                                            <a href="{{ url('admin/control').'?page=ws_data_list&Category='.$pages->category.'&type='.request()->query('type') }}" class="dropdown-item">
                                                @if (strlen($pages->description) > 75)
                                                    {{ mb_substr($pages->description,0,23) }} <br>
                                                    {{ mb_substr($pages->description,23) }}
                                                @else
                                                    {{  $pages->description }}
                                                @endif
                                            </a>
                                            @endif

                                        @endforeach
                                    </div>
                                </li>
                            @endforeach
                            @foreach ($gtype[2] as $pages)
                                @if($pages->hyper_link != '')
                                <li class="nav-item">
                                    <a href="{{ url('admin/control').$pages->hyper_link }}">
                                        <i class="fa big-icon fa-edit"></i>
                                        <span class="mini-dn">
                                            @if (strlen($pages->description) > 75)
                                            {{ mb_substr($pages->description,0,23) }} <br>
                                            {{ mb_substr($pages->description,23) }}
                                            @else
                                            {{  $pages->description }}
                                            @endif
                                        </span>
                                    </a>
                                </li>
                                @else
                                <li class="nav-item">
                                    <a
                                        href="{{ url('admin/control').'?page=ws_data_list&Category='.$pages->category.'&type='.Request::get('type') }} ">
                                        <i class="fa big-icon fa-edit"></i>
                                        <span class="mini-dn">
                                            @if (strlen($pages->description) > 75)
                                            {{ mb_substr($pages->description,0,23) }} <br>
                                            {{ mb_substr($pages->description,23) }}
                                            @else
                                            {{ $pages->description }}
                                            @endif
                                        </span>
                                    </a>
                                </li>
                                @endif
                            @endforeach
                        @else
                            @foreach ($gtype as $pages)
                                @if($pages->hyper_link != '')
                                <li class="nav-item">
                                    <a href="{{ url('admin/control').$pages->hyper_link }}">
                                        <i class="fa big-icon fa-edit"></i>
                                        <span class="mini-dn">
                                            @if (strlen($pages->description) > 75)
                                            {{ mb_substr($pages->description,0,23) }} <br>
                                            {{ mb_substr($pages->description,23) }}
                                            @else
                                            {{  $pages->description }}
                                            @endif
                                        </span>
                                    </a>
                                </li>
                                @else
                                <li class="nav-item">
                                    <a
                                        href="{{ url('admin/control').'?page=ws_data_list&Category='.$pages->category.'&type='.Request::get('type') }} ">
                                        <i class="fa big-icon fa-edit"></i>
                                        <span class="mini-dn">
                                            @if (strlen($pages->description) > 75)
                                            {{ mb_substr($pages->description,0,23) }} <br>
                                            {{ mb_substr($pages->description,23) }}
                                            @else
                                            {{ $pages->description }}
                                            @endif
                                        </span>
                                    </a>
                                </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Header top area start-->
        <div class="content-inner-all">
            <div class="header-top-area">
                <div class="fixed-header-top">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                                <button type="button" id="sidebarCollapse"
                                    class="btn bar-button-pro header-drl-controller-btn btn-info navbar-btn">
                                    <i class="fa fa-bars"></i>
                                </button>
                            </div>
                            <!-- Manu Head Start -->
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <div class="header-top-menu tabl-d-n">
                                    <ul class="nav navbar-nav mai-top-nav">
                                        @foreach ($head_menu as $head_menus)
                                        <li class="nav-item">
                                            <a href="{{ url('admin/control').'?type='.$head_menus->type }}"
                                                class="nav-link">{{ $numberDesc[$head_menus->type] }}</a>
                                        </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                            <!-- Manu Head End -->
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                                <div class="header-right-info">
                                    <ul class="nav navbar-nav mai-top-nav header-right-menu">

                                        <li class="nav-item">
                                            <a href="{{ route('admin.logout') }}" role="button" aria-expanded="false"
                                                class="nav-link dropdown-toggle" data-toggle="modal"
                                                data-target="#alertLogout" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                <span
                                                    class="adminpro-icon adminpro-user-rounded header-riht-inf"></span>
                                                <span class="admin-name">Log Out</span>
                                                <form id="logout-form" action="{{ route('admin.logout') }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <h1 class="f-Kanit text-center" style="padding-top: 10px;">
                                    <b>ระบบการจัดการเว็บไซต์</b><small> soatsolution</small></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Header top area end-->
            <!-- Breadcome start-->
            <div class="breadcome-area mg-b-30 small-dn" style="margin-top: 50px;">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="breadcome-list shadow-reset">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="breadcome-heading">
                                            <form name="myform" id="myform" role="search" class="" method="POST"
                                                action="{{ url('searchControl') }}">
                                                @csrf
                                                <input type="text" name="sheach" placeholder="Search..."
                                                    class="form-control">
                                                <a onclick="document.myform.submit()" href="#"><i
                                                        class="fa fa-search"></i></a>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <h2>
                                            <span class="bread-blod">
                                                @if ( isset($_GET['backPage']) )
                                                    <a href="javascript:void(0);" onclick="window.history.back();">กลับ</a> / 
                                                @endif
                                                {{ f_get_category_description(Request('Category')) }}</span>
                                        </h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Breadcome End-->
            <!-- /////////////////////////////////////////////////////  Mobile Start /////////////////////////////////////////////////// -->

            <!-- Mobile Menu start -->
            <div class="mobile-menu-area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="mobile-menu">
                                <nav id="dropdown">
                                    <ul class="mobile-menu-nav">
                                        <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> กลับไปหน้าเว็บไซต์</a></li>
                                        <li><a href="{{ url('admin/control') }}"><i class="fa fa-home"></i> หน้าแรกของ ADMIN</a></li>
                                        @foreach ($head_menu as $head_menus)
                                            <li><a data-toggle="collapse" data-target="#Charts">{{ $numberDesc[$head_menus->type] }}<span class="admin-project-icon adminpro-icon adminpro-down-arrow"></span></a>
                                                <ul class="collapse dropdown-header-top">
                                                    @foreach ($list_type[$head_menus->type] as $itemtype)
                                                        <li>
                                                            <a href="{{ $itemtype->hyper_link != '' ? url('admin/control').$itemtype->hyper_link : url('admin/control').'?page=ws_data_list&Category='.$itemtype->category.'&type='.$head_menus->type }}">- {{$itemtype->description}}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <!-- Mobile Menu end -->

            <!-- Breadcome start-->
            <div class="breadcome-area des-none mg-b-30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="breadcome-list map-mg-t-40-gl shadow-reset">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="breadcome-heading">
                                            <form role="search" class="">
                                              <input type="text" placeholder="Search..." class="form-control">
                                              <a href=""><i class="fa fa-search"></i></a>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <h4>
                                            <ul class="breadcome-menu">
                                                @if ( isset($_GET['backPage']) )
                                                    <li>
                                                        <a href="javascript:void(0);" onclick="window.history.back();">
                                                            กลับ
                                                        </a> 
                                                        <span class="bread-slash">/</span>
                                                    </li>
                                                @endif
                                                <li>
                                                    <span class="bread-blod">{{ f_get_category_description(Request('Category')) }}</span>
                                                </li>
                                            </ul>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <!-- Breadcome End-->
            <!-- /////////////////////////////////////////////////////  Mobile End //////////////////////////////////////////////////// -->

            @php
            echo f_get_page(Request::get('page'));
            @endphp

        </div>
    </div>

    @include('admin.layout.footer')

</body>

</html>

{{--====== // Set Menu Bar Header Top =======--}}
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
<script>
    $(document).ready(function(){
        $('.fixed-header-top').css({
            "left" : $('#sidebar').width()
        });
    });
    
</script>