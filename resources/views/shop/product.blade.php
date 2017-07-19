@extends('layout.main')
@section('content')
<!-- Main Content -->
<div class="container m-t-3">
    <div class="row">

        <!-- Image List -->
        <div class="col-sm-4">
            @if(empty($product['image']))
            <div class="image-detail">
                <img src="{{asset('images/up/empty.png')}}" alt="Empty image">
            </div>
            @else
            <div class="image-detail">
                <img src="{{asset("images/up/{$product['image']}")}}" data-zoom-image="{{asset("images/up/{$product['image']}")}}" alt="{{$product['title']}}">
            </div>
                @if(count($product['images']) > 1)
            <div class="products-slider-detail owl-carousel owl-theme m-b-2">
                <a href="#">
                    <img src="{{asset("images/up/{$product['image']}")}}" data-zoom-image="{{asset("images/up/{$product['image']}")}}" alt="{{$product['title']}}" class="img-thumbnail">
                </a>
                @foreach($product['images'] as $image)
                @if($image['image'] != $product['image'] )
                <a href="#">
                    <img src="{{asset("images/up/{$image['image']}")}}" data-zoom-image="{{asset("images/up/{$image['image']}")}}" alt="{{$product['title']}}" class="img-thumbnail">
                </a>
                @endif
                @endforeach
            </div>
                @endif
            @endif

            <div class="title"><span>Share to</span></div>
            <div class="share-button m-b-3">
                <button type="button" class="btn btn-primary"><i class="fa fa-facebook"></i></button>
                <button type="button" class="btn btn-info"><i class="fa fa-twitter"></i></button>
                <button type="button" class="btn btn-danger"><i class="fa fa-google-plus"></i></button>
                <button type="button" class="btn btn-primary"><i class="fa fa-linkedin"></i></button>
                <button type="button" class="btn btn-warning"><i class="fa fa-envelope"></i></button>
            </div>
        </div>
        <!-- End Image List -->

        <div class="col-sm-8">
            <div class="title-detail">{{$product['title']}}</div>
            <table class="table table-detail">
                <tbody>
                    <tr>
                        <td>Price</td>
                        <td>
                            @if(empty($product['sale']))
                            <div>${{$product['price']}} </div>
                            @else
                            <div class="price">
                                <div>
                                    ${{$product['price']*(1-$product['sale']['discount']/100)}} 
                                    <span class="label-tags">
                                        <span class="label label-default">-{{$product['sale']['discount']}}%</span>
                                    </span>
                                </div>
                                <span class="price-old">${{$product['price']}}</span>
                            </div>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Availability</td>
                        <td>
                            @if(empty($product['stock']))
                            <span class="label label-danger arrowed"><s>Out of Stock</s></span>
                            @elseif($product['stock'] == 1)
                            <span class="label label-warning arrowed">Last 1 Ready in Stock</span>
                            @elseif($product['stock'] > 1)
                            <span class="label label-success arrowed">Ready in Stock</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Quantity</td>
                        <td>
                            <div class="input-qty">
                                <input type="text" value="1" class="form-control text-center"/>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button class="btn btn-theme m-b-1" type="button"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
                            <button class="btn btn-theme m-b-1" type="button"><i class="fa fa-align-left"></i> Add to Compare</button>
                            <button class="btn btn-theme m-b-1" type="button"><i class="fa fa-heart"></i> Add to Wishlist</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="col-md-8">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#desc" aria-controls="desc" role="tab" data-toggle="tab">Description</a></li>
                <li role="presentation"><a href="#review" aria-controls="review" role="tab" data-toggle="tab">Reviews (2)</a></li>
            </ul>
            <!-- End Nav tabs -->

            <!-- Tab panes -->
            <div class="tab-content tab-content-detail">

                <!-- Description Tab Content -->
                <div role="tabpanel" class="tab-pane active" id="desc">
                    <div class="well">
                        <p>
                            {{$product['article']}}
                        </p>
                    </div>
                </div>
                <!-- End Description Tab Content -->

                <!-- Review Tab Content -->
                <div role="tabpanel" class="tab-pane" id="review">
                    <div class="well">
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object img-thumbnail" alt="64x64" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCI+PHJlY3Qgd2lkdGg9IjY0IiBoZWlnaHQ9IjY0IiBmaWxsPSIjZWVlIi8+PHRleHQgdGV4dC1hbmNob3I9Im1pZGRsZSIgeD0iMzIiIHk9IjMyIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjEycHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+NjR4NjQ8L3RleHQ+PC9zdmc+">
                                </a>
                                <div class="product-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half-o"></i>
                                </div>
                            </div>
                            <div class="media-body">
                                <h5 class="media-heading"><strong>John Thor</strong></h5>
                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object img-thumbnail" alt="64x64" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCI+PHJlY3Qgd2lkdGg9IjY0IiBoZWlnaHQ9IjY0IiBmaWxsPSIjZWVlIi8+PHRleHQgdGV4dC1hbmNob3I9Im1pZGRsZSIgeD0iMzIiIHk9IjMyIiBzdHlsZT0iZmlsbDojYWFhO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1zaXplOjEycHg7Zm9udC1mYW1pbHk6QXJpYWwsSGVsdmV0aWNhLHNhbnMtc2VyaWY7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+NjR4NjQ8L3RleHQ+PC9zdmc+">
                                </a>
                                <div class="product-rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-half-o"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                            </div>
                            <div class="media-body">
                                <h5 class="media-heading"><strong>Michael Lelep</strong></h5>
                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                            </div>
                        </div>
                        <hr/>
                        <h4 class="m-b-2">Add your review</h4>
                        <form role="form">
                            <div class="form-group">
                                <label for="Name">Name</label>
                                <input type="text" id="Name" class="form-control" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <label for="Email">Email</label>
                                <input type="text" id="Email" class="form-control" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label>Rating</label><div class="clearfix"></div>
                                <div class="input-rating"></div>
                            </div>
                            <div class="form-group">
                                <label for="Review">Your Review</label>
                                <textarea id="Review" class="form-control" rows="5" placeholder="Your Review"></textarea>
                            </div>
                            <button type="submit" class="btn btn-theme">Submit Review</button>
                        </form>
                    </div>
                </div>
                <!-- End Review Tab Content -->

            </div>
            <!-- End Tab panes -->

        </div>
    </div>

    <!-- Related Products -->
    <div class="row m-t-3">
        <div class="col-xs-12">
            <div class="title"><span>Related Products</span></div>
            <div class="related-product-slider owl-carousel owl-theme owl-controls-top-offset">
                <div class="box-product-outer">
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
                <div class="box-product-outer">
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
                <div class="box-product-outer">
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
                <div class="box-product-outer">
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
                <div class="box-product-outer">
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
                <div class="box-product-outer">
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
            </div>
        </div>
    </div>
    <!-- End Related Products -->
    <script>
        var max_qty = {{$product['stock']}};
    </script>
</div>

<!-- End Main Content -->
@endsection