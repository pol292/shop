@extends('layout.main')
@section('content')
<!-- Main Content -->
<div class="container m-t-2">
    <div class="row">

        <!-- Vertical Menu -->
        <div class="col-md-3 m-b-1">
            <div class="title"><span>Categories</span></div>
            <nav class="sidebar-nav">
                <ul class="metismenu vertical-menu">
                    @if(empty($categories))
                    <li><a class="active">No categories in system</a></li>
                    @else
                    @foreach($categories as $categorie)
                    <li>
                        <a href="{{url("shop/{$categorie['url']}")}}">
                            {{$categorie['title']}}
                        </a>
                    </li>
                    @endforeach
                    <li>
                        <a href="{{url("shop/sale")}}" class="text-center">
                            <span class="label label-danger arrowed-right pull-left">Up to {{ceil($max_discount)}}%</span>
                            <strong>Sale</strong>
                            <span class="label label-danger arrowed pull-right">Up to {{ceil($max_discount)}}%</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>

            <div class="m-t-3">
                <div class="title"><span>New Arrivals</span></div>
                @if(!empty($new_product))
                <div class="widget-slider owl-carousel owl-theme owl-controls-top-offset m-b-2">
                    @foreach($new_product as $new)
                    <div class="box-product-outer">
                        <div class="box-product">
                            <div class="img-wrapper">
                                <a href="{{url("shop/{$new['category']['url']}/{$new['url']}")}}">
                                    <img alt="Product" src="{{asset("images/up/{$new['image']}")}}">
                                </a>
                                <div class="tags tags-left">
                                    <span class="label-tags"><a href="{{url("shop/{$new['category']['url']}/{$new['url']}")}}"><span class="label label-success arrowed-right">New Arrivals</span></a></span>
                                </div>
                                @if(!empty($new['sale']))
                                <div class="tags">
                                    <span class="label-tags">
                                        <a href="{{url("shop/{$new['category']['url']}/{$new['url']}")}}">
                                            <span class="label label-default arrowed">-{{$new['sale']['discount']}}%</span>
                                        </a>
                                    </span>
                                    <span class="label-tags">
                                        <a href="{{url("shop/{$new['category']['url']}/{$new['url']}")}}">
                                            <span class="label label-{{$new['sale']['color']}} arrowed">Sale</span>
                                        </a>
                                    </span>
                                </div>
                                @endif
                                <div class="option">
                                    <a href="#" data-toggle="tooltip" title="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                                    <a href="#" data-toggle="tooltip" title="Add to Compare"><i class="fa fa-align-left"></i></a>
                                    <a href="#" data-toggle="tooltip" title="Add to Wishlist" class="wishlist"><i class="fa fa-heart"></i></a>
                                </div>
                            </div>
                            <h6><a href="{{url("shop/{$new['category']['url']}/{$new['url']}")}}">WranglerGrey Printed Slim Fit Round Neck T-Shirt</a></h6>
                            @if(empty($new['sale']))
                            <div>${{$new['price']}} </div>
                            @else
                            <div class="price">
                                <div>
                                    ${{$new['price']*(1-$new['sale']['discount']/100)}} 
                                    <span class="label-tags">
                                        <span class="label label-default">-{{$new['sale']['discount']}}%</span>
                                    </span>
                                </div>
                                <span class="price-old">${{$new['price']}}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                @endif
            </div>
        </div>
        <!-- End Vertical Menu -->

        <div class="clearfix visible-sm visible-xs"></div>

        <div class="col-md-9">

            <!-- Featured -->
            <div class="title"><span>Sale</span></div>
            @if(!empty($sale_product))
            @foreach($sale_product as $sale)
            <div class="col-xs-6 col-sm-4 col-lg-3 box-product-outer">
                <div class="box-product">
                    <div class="img-wrapper">
                        <a href="{{url("shop/{$sale['category']['url']}/{$sale['url']}")}}">
                            <img alt="Product" src="{{asset("images/up/{$sale['image']}")}}">
                        </a>
                        @if(!empty($sale['sale']))
                        <div class="tags">
                            <span class="label-tags">
                                <a href="{{url("shop/{$sale['category']['url']}/{$sale['url']}")}}">
                                    <span class="label label-default arrowed">-{{$sale['sale']['discount']}}%</span>
                                </a>
                            </span>
                        </div>
                        <div class="tags tags-left">
                            <span class="label-tags">
                                <a href="{{url("shop/{$sale['category']['url']}/{$sale['url']}")}}">
                                    <span class="label label-{{$sale['sale']['color']}} arrowed-right">Sale</span>
                                </a>
                            </span>
                        </div>
                        @endif
                        <div class="option">
                            <a href="#" data-toggle="tooltip" title="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                            <a href="#" data-toggle="tooltip" title="Add to Compare"><i class="fa fa-align-left"></i></a>
                            <a href="#" data-toggle="tooltip" title="Add to Wishlist" class="wishlist"><i class="fa fa-heart"></i></a>
                        </div>
                    </div>
                    <h6><a href="{{url("shop/{$sale['category']['url']}/{$sale['url']}")}}">{{$sale['title']}}</a></h6>
                    @if(empty($sale['sale']))
                        <div>${{$sale['price']}} </div>
                        @else
                        <div class="price">
                            <div>
                                ${{$sale['price']*(1-$sale['sale']['discount']/100)}} 
                                <span class="label-tags">
                                    <span class="label label-default">-{{$sale['sale']['discount']}}%</span>
                                </span>
                            </div>
                            <span class="price-old">${{$sale['price']}}</span>
                        </div>
                        @endif
                    <div class="rating">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-half-o"></i>
                        <a href="#">(5 reviews)</a>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
            <!-- End Featured -->
            <div class="clearfix @if(!empty($sale_product) && count($sale_product) == 4) visible-sm visible-xs @endif"></div>


            <!-- Collection -->
            <div class="title m-t-2"><span>Random Items</span></div>
            <div class="product-slider owl-carousel owl-theme owl-controls-top-offset">
                @if(!empty($random_list_product))
                @foreach($random_list_product as $random)
                <div class="box-product-outer">
                    <div class="box-product">
                        <div class="img-wrapper">
                            <a href="{{url("shop/{$random['category']['url']}/{$random['url']}")}}">
                                <img alt="Product" src="{{asset("images/up/{$random['image']}")}}">
                            </a>
                            @if(!empty($random['sale']))
                            <div class="tags">
                                <span class="label-tags">
                                    <a href="{{url("shop/{$random['category']['url']}/{$random['url']}")}}">
                                        <span class="label label-default arrowed">-{{$new['sale']['discount']}}%</span>
                                    </a>
                                </span>
                                <span class="label-tags">
                                    <a href="{{url("shop/{$random['category']['url']}/{$random['url']}")}}">
                                        <span class="label label-{{$new['sale']['color']}} arrowed">Sale</span>
                                    </a>
                                </span>
                            </div>
                            @endif
                            <div class="option">
                                <a href="#" data-toggle="tooltip" title="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                                <a href="#" data-toggle="tooltip" title="Add to Compare"><i class="fa fa-align-left"></i></a>
                                <a href="#" data-toggle="tooltip" title="Add to Wishlist" class="wishlist"><i class="fa fa-heart"></i></a>
                            </div>
                        </div>
                        <h6>
                            <a href="{{url("shop/{$random['category']['url']}/{$random['url']}")}}">
                                PhosphorusGrey Melange Printed V Neck T-Shirt
                            </a>
                        </h6>
                        @if(empty($random['sale']))
                        <div>${{$random['price']}} </div>
                        @else
                        <div class="price">
                            <div>
                                ${{$random['price']*(1-$random['sale']['discount']/100)}} 
                                <span class="label-tags">
                                    <span class="label label-default">-{{$random['sale']['discount']}}%</span>
                                </span>
                            </div>
                            <span class="price-old">${{$random['price']}}</span>
                        </div>
                        @endif
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-half-o"></i>
                            <i class="fa fa-star-o"></i>
                            <a href="#">(5 reviews)</a>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
            <!-- End Collection -->

        </div>

    </div>
</div>
<!-- End Main Content -->

@endsection