@extends('layout.main')
@section('content')
<!-- Main Content -->
<div class="container m-t-3">

    <div class="row">

        <!-- Filter Sidebar -->
        <div class="col-sm-3 hidden-xs">
            <form>
                <div class="filter-sidebar">
                    <div class="title"><span>Sort By</span></div>
                    <ul>
                        <li>
                            <select name="sort" class="selectpicker" data-width="100%">
                                <option value="0">Recomended</option>
                                <option value="lth">Low Price » High Price</option>
                                <option value="htl">High Price » High Price</option>
                            </select>
                        </li>
                    </ul>
                </div>

                <div class="filter-sidebar">
                    <div class="title"><span>Show per page</span></div>
                    <ul>
                        <li>
                            <select name="spg" class="selectpicker" data-width="100%">
                                <option value="8">8</option>
                                <option value="12">12</option>
                                <option value="16">16</option>
                                <option value="20">20</option>
                            </select>
                        </li>
                    </ul>
                </div>

                <div class="filter-sidebar">
                    <div class="title"><span>Price Range</span></div>
                    <div id="range-value">Range: <span id="min-price"></span> - <span id="max-price"></span></div>
                    <input type="hidden" name="min-price" value="">
                    <input type="hidden" name="max-price" value="">
                    <div class="price-range">
                        <div id="price"></div>
                    </div>
                </div>

                <div class="btn-group-justified">
                    <div class="btn-group">
                        <input type="submit" class="btn btn-theme" value="Sort">
                    </div>
                </div>            
            </form>
        </div>
        <!-- End Filter Sidebar -->

        <!-- Product List -->
        <div class="col-sm-9">
            <div class="row filter-sidebar">
                <article>
                    <h1 class="title"><span>{{$cat['title']}}</span></h1>
                    <div class="alert alert-color">{{$cat['article']}}</div>
                </article>
            </div>


            <div class="col-xs-6 col-md-4 col-lg-3 box-product-outer">
                <div class="box-product">
                    <div class="img-wrapper">
                        <a href="detail.html">
                            <img alt="Product" src="images/demo/p1-1.jpg">
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
                    <h6><a href="detail.html">WranglerGrey Printed Slim Fit Round Neck T-Shirt</a></h6>
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
            <div class="col-xs-6 col-md-4 col-lg-3 box-product-outer">
                <div class="box-product">
                    <div class="img-wrapper">
                        <a href="detail.html">
                            <img alt="Product" src="images/demo/p2-1.jpg">
                        </a>
                        <div class="tags tags-left">
                            <span class="label-tags"><span class="label label-success arrowed-right">New Arrivals</span></span>
                        </div>
                        <div class="option">
                            <a href="#" data-toggle="tooltip" title="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                            <a href="#" data-toggle="tooltip" title="Add to Compare"><i class="fa fa-align-left"></i></a>
                            <a href="#" data-toggle="tooltip" title="Add to Wishlist" class="wishlist"><i class="fa fa-heart"></i></a>
                        </div>
                    </div>
                    <h6><a href="detail.html">CelioKhaki Printed Round Neck T-Shirt</a></h6>
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
            <div class="clearfix visible-xs visible-sm"></div>
            <div class="col-xs-6 col-md-4 col-lg-3 box-product-outer">
                <div class="box-product">
                    <div class="img-wrapper">
                        <a href="detail.html">
                            <img alt="Product" src="images/demo/p3-1.jpg">
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
                    <h6><a href="detail.html">CelioOff White Printed Round Neck T-Shirt</a></h6>
                    <div class="price">
                        <div>$13.50</div>
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
            <div class="col-xs-6 col-md-4 col-lg-3 hidden-md box-product-outer">
                <div class="box-product">
                    <div class="img-wrapper">
                        <a href="detail.html">
                            <img alt="Product" src="images/demo/p4-1.jpg">
                        </a>
                        <div class="tags">
                            <span class="label-tags"><span class="label label-primary arrowed">Popular</span></span>
                        </div>
                        <div class="option">
                            <a href="#" data-toggle="tooltip" title="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                            <a href="#" data-toggle="tooltip" title="Add to Compare"><i class="fa fa-align-left"></i></a>
                            <a href="#" data-toggle="tooltip" title="Add to Wishlist" class="wishlist"><i class="fa fa-heart"></i></a>
                        </div>
                    </div>
                    <h6><a href="detail.html">Levi'sNavy Blue Printed Round Neck T-Shirt</a></h6>
                    <div class="price">
                        <div>$13.50</div>
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
            <div class="clearfix"></div>
            <div class="col-xs-6 col-md-4 col-lg-3 box-product-outer">
                <div class="box-product">
                    <div class="img-wrapper">
                        <a href="detail.html">
                            <img alt="Product" src="images/demo/p5-1.jpg">
                        </a>
                        <div class="tags tags-left">
                            <span class="label-tags"><span class="label label-primary arrowed-right">Pupolar</span></span>
                        </div>
                        <div class="option">
                            <a href="#" data-toggle="tooltip" title="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                            <a href="#" data-toggle="tooltip" title="Add to Compare"><i class="fa fa-align-left"></i></a>
                            <a href="#" data-toggle="tooltip" title="Add to Wishlist" class="wishlist"><i class="fa fa-heart"></i></a>
                        </div>
                    </div>
                    <h6><a href="detail.html">IncultAcid Wash Raglan Crew Neck T-Shirt</a></h6>
                    <div class="price">
                        <div>$13.50 <span class="label-tags"><span class="label label-danger arrowed">-10%</span></span></div>
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
            <div class="col-xs-6 col-md-4 col-lg-3 box-product-outer">
                <div class="box-product">
                    <div class="img-wrapper">
                        <a href="detail.html">
                            <img alt="Product" src="images/demo/p6-1.jpg">
                        </a>
                        <div class="tags">
                            <span class="label-tags"><span class="label label-danger arrowed">Hot Item</span></span>
                        </div>
                        <div class="option">
                            <a href="#" data-toggle="tooltip" title="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                            <a href="#" data-toggle="tooltip" title="Add to Compare"><i class="fa fa-align-left"></i></a>
                            <a href="#" data-toggle="tooltip" title="Add to Wishlist" class="wishlist"><i class="fa fa-heart"></i></a>
                        </div>
                    </div>
                    <h6><a href="detail.html">Avoir EnvieOlive Printed Round Neck T-Shirt</a></h6>
                    <div class="price">
                        <div>$13.50 <span class="label-tags"><span class="label label-success arrowed">-10%</span></span></div>
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
            <div class="clearfix visible-xs visible-sm"></div>
            <div class="col-xs-6 col-md-4 col-lg-3 box-product-outer">
                <div class="box-product">
                    <div class="img-wrapper">
                        <a href="detail.html">
                            <img alt="Product" src="images/demo/p7-1.jpg">
                        </a>
                        <div class="tags">
                            <span class="label-tags"><span class="label label-default arrowed">Hot Item</span></span>
                        </div>
                        <div class="option">
                            <a href="#" data-toggle="tooltip" title="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                            <a href="#" data-toggle="tooltip" title="Add to Compare"><i class="fa fa-align-left"></i></a>
                            <a href="#" data-toggle="tooltip" title="Add to Wishlist" class="wishlist"><i class="fa fa-heart"></i></a>
                        </div>
                    </div>
                    <h6><a href="detail.html">ElaboradoBrown Printed Round Neck T-Shirt</a></h6>
                    <div class="price">
                        <div>$13.50 <span class="label-tags"><span class="label label-primary arrowed">-10%</span></span></div>
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
            <div class="col-xs-6 col-md-4 col-lg-3 hidden-md box-product-outer">
                <div class="box-product">
                    <div class="img-wrapper">
                        <a href="detail.html">
                            <img alt="Product" src="images/demo/polo1.jpg">
                        </a>
                        <div class="tags">
                            <span class="label-tags"><span class="label label-success arrowed">New Arrivals</span></span>
                        </div>
                        <div class="option">
                            <a href="#" data-toggle="tooltip" title="Add to Cart"><i class="fa fa-shopping-cart"></i></a>
                            <a href="#" data-toggle="tooltip" title="Add to Compare"><i class="fa fa-align-left"></i></a>
                            <a href="#" data-toggle="tooltip" title="Add to Wishlist" class="wishlist"><i class="fa fa-heart"></i></a>
                        </div>
                    </div>
                    <h6><a href="detail.html">IncultGeo Print Polo T-Shirt</a></h6>
                    <div class="price">
                        <div>$13.50 <span class="label-tags"><span class="label label-default arrowed">-10%</span></span></div>
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

            Pagination 
            <div class="col-xs-12 text-center">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="disabled"><span>&laquo;</span></li>
                        <li class="disabled"><span>&lsaquo;</span></li>
                        <li class="active"><span>1</span></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">&rsaquo;</a></li>
                        <li><a href="#">&raquo;</a></li>
                    </ul>
                </nav>
            </div>
            End Pagination 

        </div>
        <!-- End Product List -->

    </div>
</div>
<!-- End Main Content -->
@endsection