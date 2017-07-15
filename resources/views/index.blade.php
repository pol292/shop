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
                            <span class="label label-danger arrowed-right pull-left">Up to 20%</span>
                            <strong>Sale</strong>
                            <span class="label label-danger arrowed pull-right">Up to 20%</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>
        </div>
        <!-- End Vertical Menu -->

        <div class="clearfix visible-sm visible-xs"></div>

        <div class="col-md-9">

            <!-- Featured -->
            <div class="title"><span>Featured Products</span></div>
            <div class="col-xs-6 col-sm-4 col-lg-3 box-product-outer">
                <div class="box-product">
                    <div class="img-wrapper">
                        <a href="detail.html">
                            <img alt="Product" src="images/demo/polo1.jpg">
                        </a>
                        <div class="tags">
                            <span class="label-tags"><span class="label label-default arrowed">Featured</span></span>
                        </div>
                        <div class="tags tags-left">
                            <span class="label-tags"><span class="label label-danger arrowed-right">Sale</span></span>
                        </div>
                        <div class="option">
                            <a href="#" data-toggle="tooltip" title="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                            <a href="#" data-toggle="tooltip" title="Add to Compare"><i class="fa fa-align-left"></i></a>
                            <a href="#" data-toggle="tooltip" title="Add to Wishlist" class="wishlist"><i class="fa fa-heart"></i></a>
                        </div>
                    </div>
                    <h6><a href="detail.html">IncultGeo Print Polo T-Shirt</a></h6>
                    <div class="price">
                        <div>$13.50 <span class="label-tags"><span class="label label-default">-10%</span></span></div>
                        <span class="price-old">$15.00</span>
                    </div>
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
            <div class="col-xs-6 col-sm-4 col-lg-3 box-product-outer">
                <div class="box-product">
                    <div class="img-wrapper">
                        <a href="detail.html">
                            <img alt="Product" src="images/demo/polo2.jpg">
                        </a>
                        <div class="tags">
                            <span class="label-tags"><span class="label label-default arrowed">Featured</span></span>
                        </div>
                        <div class="tags tags-left">
                            <span class="label-tags"><span class="label label-success arrowed-right">Sale</span></span>
                        </div>
                        <div class="option">
                            <a href="#" data-toggle="tooltip" title="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                            <a href="#" data-toggle="tooltip" title="Add to Compare"><i class="fa fa-align-left"></i></a>
                            <a href="#" data-toggle="tooltip" title="Add to Wishlist" class="wishlist"><i class="fa fa-heart"></i></a>
                        </div>
                    </div>
                    <h6><a href="detail.html">Tommy HilfigerNavy Blue Printed Polo T-Shirt</a></h6>
                    <div class="price">
                        <div>$13.50 <span class="label-tags"><span class="label label-primary">-10%</span></span></div>
                        <span class="price-old">$15.00</span>
                    </div>
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
            <div class="col-xs-6 col-sm-4 col-lg-3 box-product-outer">
                <div class="box-product">
                    <div class="img-wrapper">
                        <a href="detail.html">
                            <img alt="Product" src="images/demo/polo3.jpg">
                        </a>
                        <div class="tags">
                            <span class="label-tags"><span class="label label-default arrowed">Featured</span></span>
                        </div>
                        <div class="tags tags-left">
                            <span class="label-tags"><span class="label label-primary arrowed-right">Sale</span></span>
                        </div>
                        <div class="option">
                            <a href="#" data-toggle="tooltip" title="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                            <a href="#" data-toggle="tooltip" title="Add to Compare"><i class="fa fa-align-left"></i></a>
                            <a href="#" data-toggle="tooltip" title="Add to Wishlist" class="wishlist"><i class="fa fa-heart"></i></a>
                        </div>
                    </div>
                    <h6><a href="detail.html">WranglerNavy Blue Solid Polo T-Shirt</a></h6>
                    <div class="price">
                        <div>$13.50 <span class="label-tags"><span class="label label-success">-10%</span></span></div>
                        <span class="price-old">$15.00</span>
                    </div>
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
            <div class="col-xs-6 col-sm-4 col-lg-3 visible-xs visible-lg box-product-outer">
                <div class="box-product">
                    <div class="img-wrapper">
                        <a href="detail.html">
                            <img alt="Product" src="images/demo/polo4.jpg">
                        </a>
                        <div class="tags">
                            <span class="label-tags"><span class="label label-default arrowed">Featured</span></span>
                        </div>
                        <div class="tags tags-left">
                            <span class="label-tags"><span class="label label-danger arrowed-right">Sale</span></span>
                        </div>
                        <div class="option">
                            <a href="#" data-toggle="tooltip" title="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                            <a href="#" data-toggle="tooltip" title="Add to Compare"><i class="fa fa-align-left"></i></a>
                            <a href="#" data-toggle="tooltip" title="Add to Wishlist" class="wishlist"><i class="fa fa-heart"></i></a>
                        </div>
                    </div>
                    <h6><a href="detail.html">NikeAs Matchup -Pq Grey Polo T-Shirt</a></h6>
                    <div class="price">
                        <div>$13.50 <span class="label-tags"><span class="label label-danger">-10%</span></span></div>
                        <span class="price-old">$15.00</span>
                    </div>
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
            <!-- End Featured -->

            <div class="clearfix visible-sm visible-xs"></div>

            <!-- Collection -->
            <div class="title m-t-2"><span>V-Neck Collection</span></div>
            <div class="product-slider owl-carousel owl-theme owl-controls-top-offset">
                <div class="box-product-outer">
                    <div class="box-product">
                        <div class="img-wrapper">
                            <a href="detail.html">
                                <img alt="Product" src="images/demo/vneck1.jpg">
                            </a>
                            <div class="tags">
                                <span class="label-tags"><span class="label label-danger arrowed">Sale</span></span>
                                <span class="label-tags"><span class="label label-default arrowed">Collection</span></span>
                            </div>
                            <div class="option">
                                <a href="#" data-toggle="tooltip" title="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                                <a href="#" data-toggle="tooltip" title="Add to Compare"><i class="fa fa-align-left"></i></a>
                                <a href="#" data-toggle="tooltip" title="Add to Wishlist" class="wishlist"><i class="fa fa-heart"></i></a>
                            </div>
                        </div>
                        <h6><a href="detail.html">PhosphorusGrey Melange Printed V Neck T-Shirt</a></h6>
                        <div class="price">
                            <div>$13.50 <span class="label-tags"><span class="label label-danger arrowed">-10%</span></span></div>
                            <span class="price-old">$15.00</span>
                        </div>
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
                <div class="box-product-outer">
                    <div class="box-product">
                        <div class="img-wrapper">
                            <a href="detail.html">
                                <img alt="Product" src="images/demo/vneck2.jpg">
                            </a>
                            <div class="tags">
                                <span class="label-tags"><span class="label label-danger arrowed">Sale</span></span>
                                <span class="label-tags"><span class="label label-primary arrowed">Collection</span></span>
                            </div>
                            <div class="option">
                                <a href="#" data-toggle="tooltip" title="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                                <a href="#" data-toggle="tooltip" title="Add to Compare"><i class="fa fa-align-left"></i></a>
                                <a href="#" data-toggle="tooltip" title="Add to Wishlist" class="wishlist"><i class="fa fa-heart"></i></a>
                            </div>
                        </div>
                        <h6><a href="detail.html">United Colors of BenettonNavy Blue Solid V Neck T Shirt</a></h6>
                        <div class="price">
                            <div>$13.50 <span class="label-tags"><span class="label label-success arrowed">-10%</span></span></div>
                            <span class="price-old">$15.00</span>
                        </div>
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
                <div class="box-product-outer">
                    <div class="box-product">
                        <div class="img-wrapper">
                            <a href="detail.html">
                                <img alt="Product" src="images/demo/vneck3.jpg">
                            </a>
                            <div class="tags">
                                <span class="label-tags"><span class="label label-danger arrowed">Sale</span></span>
                                <span class="label-tags"><span class="label label-success arrowed">Collection</span></span>
                            </div>
                            <div class="option">
                                <a href="#" data-toggle="tooltip" title="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                                <a href="#" data-toggle="tooltip" title="Add to Compare"><i class="fa fa-align-left"></i></a>
                                <a href="#" data-toggle="tooltip" title="Add to Wishlist" class="wishlist"><i class="fa fa-heart"></i></a>
                            </div>
                        </div>
                        <h6><a href="detail.html">WranglerBlack V Neck T Shirt</a></h6>
                        <div class="price">
                            <div>$13.50 <span class="label-tags"><span class="label label-primary arrowed">-10%</span></span></div>
                            <span class="price-old">$15.00</span>
                        </div>
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
                <div class="box-product-outer">
                    <div class="box-product">
                        <div class="img-wrapper">
                            <a href="detail.html">
                                <img alt="Product" src="images/demo/vneck4.jpg">
                            </a>
                            <div class="tags">
                                <span class="label-tags"><span class="label label-danger arrowed">Sale</span></span>
                                <span class="label-tags"><span class="label label-info arrowed">Collection</span></span>
                            </div>
                            <div class="option">
                                <a href="#" data-toggle="tooltip" title="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                                <a href="#" data-toggle="tooltip" title="Add to Compare"><i class="fa fa-align-left"></i></a>
                                <a href="#" data-toggle="tooltip" title="Add to Wishlist" class="wishlist"><i class="fa fa-heart"></i></a>
                            </div>
                        </div>
                        <h6><a href="detail.html">Tagd New YorkGrey Printed V Neck T-Shirts</a></h6>
                        <div class="price">
                            <div>$13.50 <span class="label-tags"><span class="label label-default arrowed">-10%</span></span></div>
                            <span class="price-old">$15.00</span>
                        </div>
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
                <div class="box-product-outer">
                    <div class="box-product">
                        <div class="img-wrapper">
                            <a href="detail.html">
                                <img alt="Product" src="images/demo/vneck1.jpg">
                            </a>
                            <div class="tags">
                                <span class="label-tags"><span class="label label-danger arrowed">Sale</span></span>
                                <span class="label-tags"><span class="label label-default arrowed">Collection</span></span>
                            </div>
                            <div class="option">
                                <a href="#" data-toggle="tooltip" title="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                                <a href="#" data-toggle="tooltip" title="Add to Compare"><i class="fa fa-align-left"></i></a>
                                <a href="#" data-toggle="tooltip" title="Add to Wishlist" class="wishlist"><i class="fa fa-heart"></i></a>
                            </div>
                        </div>
                        <h6><a href="detail.html">PhosphorusGrey Melange Printed V Neck T-Shirt</a></h6>
                        <div class="price">
                            <div>$13.50 <span class="label-tags"><span class="label label-danger arrowed">-10%</span></span></div>
                            <span class="price-old">$15.00</span>
                        </div>
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
                <div class="box-product-outer">
                    <div class="box-product">
                        <div class="img-wrapper">
                            <a href="detail.html">
                                <img alt="Product" src="images/demo/vneck2.jpg">
                            </a>
                            <div class="tags">
                                <span class="label-tags"><span class="label label-danger arrowed">Sale</span></span>
                                <span class="label-tags"><span class="label label-primary arrowed">Collection</span></span>
                            </div>
                            <div class="option">
                                <a href="#" data-toggle="tooltip" title="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                                <a href="#" data-toggle="tooltip" title="Add to Compare"><i class="fa fa-align-left"></i></a>
                                <a href="#" data-toggle="tooltip" title="Add to Wishlist" class="wishlist"><i class="fa fa-heart"></i></a>
                            </div>
                        </div>
                        <h6><a href="detail.html">United Colors of BenettonNavy Blue Solid V Neck T Shirt</a></h6>
                        <div class="price">
                            <div>$13.50 <span class="label-tags"><span class="label label-success arrowed">-10%</span></span></div>
                            <span class="price-old">$15.00</span>
                        </div>
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
            </div>
            <!-- End Collection -->

        </div>

    </div>
</div>
<!-- End Main Content -->

@endsection