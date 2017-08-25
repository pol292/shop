<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon">
        <link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>{{$title}}</title>

        <!-- Bootstrap -->
        <link href="{{asset('bootstrap/css/bootstrap.css')}}" rel="stylesheet">

        <!-- Plugins -->
        <link href="{{asset('css/font-awesome.css')}}" rel="stylesheet">
        <link href="{{asset('css/bootstrap-select.css')}}" rel="stylesheet">
        <link href="{{asset('css/nouislider.css')}}" rel="stylesheet">
        <link href="{{asset('css/owl.carousel.css')}}" rel="stylesheet">
        <link href="{{asset('css/owl.theme.default.css')}}" rel="stylesheet">
        <link href="{{asset('css/jquery.bootstrap-touchspin.css')}}" rel="stylesheet">
        <link href="{{asset('css/metisMenu.css')}}" rel="stylesheet" id="theme">
        <link href="{{asset('css/mm-vertical.css')}}" rel="stylesheet" id="theme">
        <link href="{{asset('css/style.indigo.rounded.css')}}" rel="stylesheet" id="theme">
        <link href="{{asset('css/web.css')}}" rel="stylesheet" id="theme">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>

        <!-- Top Header -->
        <div class="top-header">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <ul class="list-inline pull-right">
                            @if(!empty(Session::get( 'user' )))
                            @php
                                $user = Session::get( 'user' );
                            @endphp
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> Hi {{$user['name']}}  <span class="caret"></span></a>
                                <ul class="dropdown-menu dropdown-menu-right ">
                                    <li><a href="{{url('user/profile')}}">My Account</a></li>
                                    @if($user['role'] === 3)
                                        <li><a href="{{url('dashboard')}}">Admin Panel</a></li>
                                    @endif
                                    @if(empty($user['facebook']))
                                        @php
                                            $facebook = [];
                                            \App\Models\User::facebookLogin($facebook , 'user/link-facebook');
                                            $facebook = $facebook['facebook'];
                                        @endphp
                                        <li role="separator" class="divider"></li>
                                        <li><a href="{{$facebook}}">Link to Facebook</a></li>
                                    @endif
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{url('user/logout')}}"><i class="fa fa-sign-out"></i> Sign-out</a></li>
                                </ul>
                            </li>
                            @else
                            <li><a href="{{url('user/register')}}"><i class="fa fa-user-plus"></i> Sign-up</a></li>
                            <li><a href="{{url('user/login')}}"><i class="fa fa-sign-in"></i> Sign-in</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Top Header -->

        <!-- Middle Header -->
        <div id="top-header" class="middle-header">
            <div id="top-content" class="container">

                <!-- messages -->
                @if ($errors->any())
                <div class="alert alert-danger message">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                @if (session('wm'))
                <div class="alert alert-danger message">
                    {{ session('wm') }}
                </div>
                @endif

                @if (session('sm'))
                <div class="alert alert-success message">
                    {{ session('sm') }}
                </div>
                @endif

                <!-- end messages -->
                <div class="row">
                    <div class="col-md-3 logo">
                        <a href="{{url('/')}}"><img alt="Logo" src="{{asset('images/logo-indigo.png')}}" class="img-responsive"  data-text-logo="Mimity Online Shop"/></a>
                    </div>
                    <form method="GET" action="{{url('shop/search')}}" class="col-sm-8 col-md-6 search-box m-t-2">

                        <div class="input-group">
                            <input type="text" name="find" class="form-control search-input" aria-label="Search here..." placeholder="Search here..." autocomplete="off" value="{{$request['find']}}">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default btn-search"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                    <div class="col-sm-4 col-md-3 cart-btn hidden-xs m-t-2">
                        @if(Cart::count())
                        @php
                            App\Models\Shop\Product::updateAllCart();
                        @endphp
                        <button type="button" class="btn btn-default dropdown-toggle" id="dropdown-cart" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <i class="fa fa-shopping-cart"></i> Shopping Cart : {{Cart::count()}} items <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-cart">
                            @foreach(Cart::content()->toArray() as $inCart)
                            <div class="media">
                                <div class="media-left">
                                    <a href="{{$inCart['options']['url']}}"><img class="media-object img-thumbnail" 
                                                                                 src="{{asset("images/up/{$inCart['options']['image']}")}}" width="50" alt="product"></a>
                                </div>
                                <div class="media-body">
                                    <a href="{{$inCart['options']['url']}}" class="media-heading">{{$inCart['name']}}</a>
                                    <div>${{$inCart['price']}} x {{$inCart['qty']}}</div>
                                </div>
                                <div class="media-right"><a href="#" class="remove-from-cart" data-rowid="{{$inCart['rowId']}}" data-toggle="tooltip" title="Remove"><i class="fa fa-remove"></i></a></div>
                            </div>
                            @endforeach
                            <div class="subtotal-cart">Subtotal: <span>${{Cart::total()}}</span></div>
                            <div class="text-center">
                                <div class="btn-group" role="group" aria-label="View Cart and Checkout Button">
                                    <a href="{{url('shop/view-cart')}}" class="btn btn-default btn-sm"><i class="fa fa-shopping-cart"></i> View Cart</a>
                                    <a href="{{url('shop/checkout')}}" class="btn btn-default btn-sm" ><i class="fa fa-check"></i> Checkout</a>
                                </div>
                            </div>
                        </div>
                        @else
                        <button type="button" class="btn btn-default ">
                            <i class="fa fa-shopping-cart"></i> Shopping Cart is empty
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- End Middle Header -->

        <!-- Navigation Bar -->
        <nav class="navbar navbar-default shadow-navbar" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="{{url('shop/view-cart')}}" class="btn btn-default btn-cart-xs visible-xs pull-right">
                        <i class="fa fa-shopping-cart"></i> Cart : {{Cart::count()}} items
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="navbar-ex1-collapse">
                    <ul class="nav navbar-nav">
                        <li @if($page_url == 'index') class="active" @endif><a href="{{url('/')}}">Home</a></li>
                        @if(!empty($menu))
                        @foreach($menu as $item)
                        @if(!empty($item['sub_menu']))
                        <li class="dropdown @if($item['pages']['url'] == $page_url) active @endif">
                            <a href="{{url($item['pages']['url'])}}">
                                {{$item['pages']['title']}} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu sub-menu">
                                @foreach($item['sub_menu'] as $sub_page)
                                @if(!empty($sub_page))
                                <li @if($sub_page['pages']['url'] == $page_url) class="active" @endif>
                                     <a href="{{url($sub_page['pages']['url'])}}">{{$sub_page['pages']['title']}}</a>
                                </li>
                                @endif
                                @endforeach
                            </ul>
                        </li>
                        @else
                        <li @if($item['pages']['url'] == $page_url) class="active" @endif>
                             <a href="{{url($item['pages']['url'])}}">{{$item['pages']['title']}}</a>
                        </li>
                        @endif
                        @endforeach
                        @endif

                    </ul>

                    <ul class="nav navbar-nav navbar-right navbar-feature visible-lg">
                        <li><a><i class="fa fa-truck"></i> Free Shipping</a></li>
                        <li><a><i class="fa fa-money"></i> Cash on Delivery</a></li>
                        <li><a><i class="fa fa-lock"></i> Secure Payment</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navigation Bar -->
        @if($title === 'Diver' && !empty($advs))
        <!-- Full Slider -->
        <style>
            .owl-carousel .item img{
                max-height: 50vh;
            }
            .text-carousel{
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                max-height: 150px;
                /*                background: rgba(0,0,0,0.5);*/
                background: linear-gradient(
                    to bottom,
                    rgba(0,0,0,0),
                    #000
                    );
                color: #fff;
                border-radius: 10px 10px 0 0;
                padding: 10px;
                padding-top: 20px;
                word-wrap: break-word;
            }
            .text-carousel a{
                color: #fff;
            }
        </style>
        <div class="container-fluid">
            <div class="row">
                <div class="owl-carousel owl-theme home-slider">
                    @foreach($advs as $adv)
                    <div class="item">
                        <a href="{{url($adv['url'])}}">
                            <div class="text-carousel">
                                <h4>{{$adv['title']}}</h4>
                                <p>
                                    {{$adv['article']}}
                                </p>
                            </div>
                        </a>
                        <a href="{{url($adv['url'])}}" class="hidden-xs">
                            <img src="{{(strpos($adv['image'] , 'http://') === 0)? url($adv['image']) : asset($adv['image'])}}" alt="Slider">
                        </a>
                        <a href="{{url($adv['url'])}}" class="visible-xs">
                            <img src="{{(strpos($adv['image'] , 'http://') === 0)? url($adv['image']) : asset($adv['image'])}}" alt="Slider">
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- End Full Slider -->
        @else
        <!-- Breadcrumbs -->
        <div class="breadcrumb-container">
            <div class="container">
                <ol class="breadcrumb">
                    @foreach($breadcrumb as $key => $b)
                    @if(!$key || $key != 'active')
                    <li><a href="{{$b['url']}}">
                            @if($b['title'] == 'home') <span class="fa fa-fw fa-home"></span> @endif
                            {{ucfirst($b['title'])}}
                        </a>
                    </li>
                    @else
                    <li class="active">
                        @if($b == 'home') <span class="fa fa-fw fa-home"></span> @endif
                        {{ucfirst($b)}}
                    </li>
                    @endif
                    @endforeach
                </ol>
            </div>
        </div>
        <!-- End Breadcrumbs -->
        @endif

        <!-- Main Content -->
        <div class="container m-t-2">
            <div class="row">
                @yield('content')
                @include('layout.pagination')
            </div>
        </div>
        <!-- End Main Content -->


        <!-- Footer -->
        <div class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="title-footer"><span>About Us</span></div>
                        <ul>
                            <li>
                                Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et doloremmagna aliqua. Ut enim ad minim... <a href="#">Read More</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="title-footer"><span>Information</span></div>
                        <ul>
                            <li><i class="fa fa-angle-double-right"></i> <a href="#">FAQ</a></li>
                            <li><i class="fa fa-angle-double-right"></i> <a href="#">Policy Privacy</a></li>
                            <li><i class="fa fa-angle-double-right"></i> <a href="#">Terms and Conditions</a></li>
                            <li><i class="fa fa-angle-double-right"></i> <a href="#">Shipping Methods</a></li>
                        </ul>
                    </div>
                    <div class="clearfix visible-sm-block"></div>
                    <div class="col-md-3 col-sm-6">
                        <div class="title-footer"><span>Categories</span></div>
                        <ul>
                            <li><i class="fa fa-angle-double-right"></i> <a href="#">Cras justo odio</a></li>
                            <li><i class="fa fa-angle-double-right"></i> <a href="#">Dapibus ac facilisis in</a></li>
                            <li><i class="fa fa-angle-double-right"></i> <a href="#">Morbi leo risus</a></li>
                            <li><i class="fa fa-angle-double-right"></i> <a href="#">Porta ac consectetur ac</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="title-footer"><span>Newsletter</span></div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatum, soluta, tempora, ipsa voluptatibus porro vel laboriosam</p>
                        <div class="input-group">
                            <input class="form-control" type="text" placeholder="Email Address">
                            <span class="input-group-btn">
                                <button class="btn btn-default subscribe-button" type="button">Subscribe</button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="title-footer"><span>Our Store</span></div>
                        <ul class="footer-icon">
                            <li><span><i class="fa fa-map-marker"></i></span> 212 Lorem Ipsum. Dolor Sit, Amet</li>
                            <li><span><i class="fa fa-phone"></i></span> +123-456-789</li>
                            <li><span><i class="fa fa-envelope"></i></span> <a href="mailto:cs@domain.tld">cs@domain.tld</a></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="title-footer"><span>Follow Us</span></div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatum</p>
                        <ul class="follow-us">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fa fa-rss"></i></a></li>
                        </ul>
                    </div>
                    <div class="clearfix visible-sm-block"></div>
                    <div class="col-md-3 col-sm-6">
                        <div class="title-footer"><span>Payment Method</span></div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptatum, soluta, tempora, ipsa voluptatibus porro vel laboriosam</p>
                        <img src="{{asset('images/payment-1.png')}}" alt="Payment-1">
                        <img src="{{asset('images/payment-2.png')}}" alt="Payment-2">
                        <img src="{{asset('images/payment-3.png')}}" alt="Payment-3">
                        <img src="{{asset('images/payment-4.png')}}" alt="Payment-4">
                        <img src="{{asset('images/payment-5.png')}}" alt="Payment-5">
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="title-footer"><span>My Account</span></div>
                        <ul>
                            <li><i class="fa fa-angle-double-right"></i> <a href="#">Orders</a></li>
                            <li><i class="fa fa-angle-double-right"></i> <a href="#">Vouchers</a></li>
                            <li><i class="fa fa-angle-double-right"></i> <a href="#">Points</a></li>
                            <li><i class="fa fa-angle-double-right"></i> <a href="#">Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="text-center copyright">
                Copyright &copy; 2016 Mimity All right reserved
            </div>
        </div>
        <!-- End Footer -->

        <a href="#top" class="back-top text-center" onclick="$('body,html').animate({scrollTop: 0}, 500); return false">
            <i class="fa fa-angle-double-up"></i>
        </a>





        <script>
            const URL = '{{url('')}}/';
        </script>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="{{asset('js/jquery/jquery.min.js')}}"></script>

        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="{{asset('js/bootstrap/bootstrap.min.js')}}"></script>

        <!-- Plugins -->
        <script src="{{asset('js/bootstrap-select.js')}}"></script>
        <script src="{{asset('js/nouislider.js')}}"></script>
        <script src="{{asset('js/owl.carousel.js')}}"></script>
        <script src="{{asset('js/jquery.ez-plus.js')}}"></script>
        <script src="{{asset('js/jquery.bootstrap-touchspin.js')}}"></script>
        <script src="{{asset('js/jquery.raty-fa.js')}}"></script>
        <script src="{{asset('js/bootstrap3-typeahead.js')}}"></script>
        <script src="{{asset('js/bootstrap-toolkit.js')}}"></script>
        <script src="{{asset('js/metisMenu.js')}}"></script>
        <script src="{{asset('js/mimity.js')}}"></script>

        <script src="{{asset('js/mimity.detail.js')}}"></script>
        @if(!empty($range))
        <script src="{{asset('js/mimity.filter-sidebar.js')}}"></script>
        @endif
        <script src="{{asset('js/web.js')}}"></script>
    </body>
</html>
