@extends('layout.main')
@section('content')
<!-- Main Content -->
<div class="container m-t-3">
    <div class="row">

        <!-- Image List -->
        <div class="col-sm-4">
            @if(empty($product['image']))
            <div class="image-detail">
                <img src="{{asset('images/empty.png')}}" alt="Empty image">
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
                @if($image != $product['image'] )
                <a href="#">
                    <img src="{{asset("images/up/{$image}")}}"  data-zoom-image="{{asset("images/up/{$image}")}}" alt="{{$product['title']}}" class="img-thumbnail">
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
                            @if(empty((float) $product['sale']))
                            <div>${{$product['price']}} </div>
                            @else
                            <div class="price">
                                <div>
                                    ${{$product['price']*(1-$product['sale']/100)}} 
                                    <span class="label-tags">
                                        <span class="label label-default">-{{$product['sale']}}%</span>
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
                            <span class="label label-danger"><s>Out of Stock</s></span>
                            @elseif($product['stock'] == 1)
                            <span class="label label-warning">Last 1 Ready in Stock</span>
                            @elseif($product['stock'] > 1)
                            <span class="label label-success">{{$product['stock']}} Ready in Stock</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>In cart</td>
                        <td>
                            @if(!empty($cart))
                            <span class="label label-default">{{$cart['qty']}} in your cart</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Quantity</td>
                        <td>
                            <div class="input-qty">
                                <input type="text" data-bts-max="{{$product['stock']}}" id='qty' value="1" class="form-control text-center"/>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>
                            <button class="addMenyToCart btn btn-theme m-b-1" type="button" data-id='{{$product['id']}}'><i class="fa fa-shopping-cart"></i> Add to Cart</button>
                            <i class="fa fa-spinner rotating" aria-hidden="true" style="color:#000;display: none; font-size: 30px; margin-right: 10px; "></i>
                            <button class="btn btn-theme m-b-1" type="button"><i class="fa fa-check"></i> Checkout</button>
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
            <div class="title"><span>Products you will love</span></div>
            <div class="related-product-slider owl-carousel owl-theme owl-controls-top-offset">
                @each('shop.skin.product_slider', $random_list_product, 'product')
            </div>
        </div>
    </div>
    <!-- End Related Products -->
</div>

<!-- End Main Content -->
@endsection