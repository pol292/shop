                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Dashboard</title>

        <!-- Bootstrap Core CSS -->
        <link href="{{asset('bootstrap/css/bootstrap.css')}}" rel="stylesheet">
        <link href="{{asset('css/jquery.bootstrap-touchspin.css')}}" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="{{asset('css/dashboard/metisMenu/metisMenu.min.css')}}" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="{{asset('css/dashboard/sb-admin-2.min.css')}}" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="{{asset('css/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">

        <!-- Custom Fonts -->
        <link href="{{asset('css/summernote/summernote.css')}}" rel="stylesheet" type="text/css"> 
        <!-- dropzone -->
        <link href="{{asset('css/dashboard/dropzone.css')}}" rel="stylesheet" type="text/css"> 

        <!-- Nestable Css -->
        <link href="{{asset('css/dashboard/nestable.css')}}" rel="stylesheet" type="text/css">


        <!-- Custom Css -->
        <link href="{{asset('css/dashboard/dashboard.css')}}" rel="stylesheet" type="text/css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.html">SB Admin v2.0</a>
                </div>
                <!-- /.navbar-header -->

                <ul class="nav navbar-top-links navbar-right">
                    <li>
                        <a href="{{url('/')}}">
                            <span class="fa fa-backward fa-fw"></span>
                            Back To Site
                        </a>
                    </li>
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="{{url('user/profile')}}"><i class="fa fa-user fa-fw"></i> User Profile</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="{{url('user/logout')}}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->

                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li>
                                <a @if($page == 'Dashboard') class="active" @endif href="{{url('dashboard')}}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                            </li>
                            <li @if($page == 'Page Manager') class="active" @endif>
                                 <a href="#"><i class="fa  fa-list-alt fa-fw"></i> CMS <span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a @if($page == 'Page Manager') class="active" @endif href="{{url('dashboard/CMS/page')}}">Page Manager</a>
                                    </li>
                                    <li>
                                        <a href="{{url('dashboard/CMS/menu/view')}}">Menu Manager</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li @if(in_array($page,['Categories Manager','Products Manager'])) class="active" @endif>
                                 <a href="#" ><i class="fa fa-shopping-bag fa-fw"></i> Shop<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a  @if($page == 'Categories Manager') class="active" @endif href="{{url('dashboard/shop/category')}}">Categories Manager</a>
                                    </li>
                                    <li>
                                        <a  @if($page == 'Products Manager') class="active" @endif href="{{url('dashboard/shop/product')}}">Products Manager</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>
                            <li>
                                <a @if($page == 'Users Manager') class="active" @endif href="{{url('dashboard/users')}}"><i class="fa fa-user fa-fw"></i> Users</a>
                            </li>
                            <li>
                                <a @if($page == 'Advertisings Manager') class="active" @endif href="{{url('dashboard/advertisings')}}"><i class="fa fa-bullhorn fa-fw"></i> Advertisings</a>
                            </li>
                            <li @if( strpos($page,'Recovery') === 0) class="active" @endif>
                                 <a href="#" ><i class="fa fa-history fa-fw"></i> Backup<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a @if( $page == 'Recovery') class="active" @endif href="{{url('dashboard/restore/history/all')}}">Recovery All</a>
                                    </li>
                                    <li>
                                        <a href="{{url('dashboard/restore/history/page')}}">Recovery Page</a>
                                    </li>
                                    <li>
                                        <a href="{{url('dashboard/restore/history/menu')}}">Recovery Menu</a>
                                    </li>
                                </ul>
                                <!-- /.nav-second-level -->
                            </li>

                        </ul>
                    </div>
                    <!-- /.sidebar-collapse -->
                </div>
                <!-- /.navbar-static-side -->
            </nav>

            <!-- Page Content -->
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">{{$page}} <small>@if(!empty($subtitle)) {{$subtitle}} @endif</small></h1>

                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            @if (session('wm'))
                            <div class="alert alert-warning">
                                {{ session('wm') }}
                            </div>
                            @endif

                            @if (session('sm'))
                            <div id="sm" class="alert alert-success">
                                {{ session('sm') }}
                            </div>
                            @endif

                            @yield('content')

                            @include('layout.pagination')



                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->

        </div>


        <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="Delete content model">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="exampleModalLabel">New message</h4>
                    </div>
                    <div id='delete-msg' class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button id="send-delete" type="button" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#wrapper -->
        <script>
            const URL = '{{url('')}}/';
        </script>
        <!-- jQuery -->

        <script src="{{asset('js/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('js/jquery/jquery-ui.min.js')}}"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="{{asset('js/bootstrap/bootstrap.min.js')}}"></script>
        <script src="{{asset('js/jquery.bootstrap-touchspin.js')}}"></script>

        <!-- Metis Menu Plugin JavaScript -->
        <script src="{{asset('js/dashboard/metisMenu/metisMenu.min.js')}}"></script>

        <!-- sb-admin-2 Theme JavaScript -->
        <script src="{{asset('js/dashboard/sb-admin-2.min.js')}}"></script>

        <!-- Drag and drop -->
        <script src="{{asset('js/dashboard/jquery.nestable.js')}}"></script>
        <!-- dropzone -->
        <script src="{{asset('js/dashboard/dropzone.js')}}"></script>

        <!-- Summernote -->
        <script src="{{asset('js/summernote/summernote.min.js')}}"></script>

        <!-- Custom Theme JavaScript -->
        <script src="{{asset('js/dashboard/dashboard.js')}}"></script>


    </body>

</html>
