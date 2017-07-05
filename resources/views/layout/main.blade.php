<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Heroic Features - Start Bootstrap Template</title>

        <!-- Bootstrap Core CSS -->
        <link href="{{asset('css/bootstrap/bootstrap.min.css')}}" rel="stylesheet">

        <!-- heroic CSS -->
        <link href="{{asset('css/heroic-features.css')}}" rel="stylesheet">

        <!-- Pol CSS -->
        <link href="{{asset('css/style.css')}}" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Start Bootstrap</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        @if(!empty($menu))
                            @foreach($menu as $item)
                                <li>
                                    @if(!empty($item['sub_menu']))
                                    <li class="dropdown">
                                        <a href="{{$item['pages']['url']}}">
                                            {{$item['pages']['title']}} <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu sub-menu">
                                        @foreach($item['sub_menu'] as $sub_page)
                                            @if(!empty($sub_page))
                                                <li>
                                                    <a href="{{$sub_page['pages']['url']}}">{{$sub_page['pages']['title']}}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                        </ul>
                                    </li>
                                    @else
                                    <a href="{{$item['pages']['url']}}">{{$item['pages']['title']}}</a>
                                    @endif
                                </li>
                            @endforeach
                        @endif

                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>

        <!-- Page Content -->
        <div class="container">

            <div class="row">
                <article class="col-md-12">
                    @yield('content')
                </article>
            </div>


            <hr>

            <!-- Footer -->
            <footer>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <p>Copyright &copy; Your WebShop {{date('Y')}}</p>
                    </div>
                </div>
            </footer>

        </div>
        <!-- /.container -->

        <!-- jQuery -->
        <script src="{{asset('js/jquery/jquery.min.js')}}"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="{{asset('js/bootstrap/bootstrap.min.js')}}"></script>

    </body>

</html>