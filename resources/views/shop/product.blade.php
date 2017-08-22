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
                <li role="presentation"><a href="#review" aria-controls="review" role="tab" data-toggle="tab">Reviews ({{count($product['rates'])}})</a></li>
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
                        @if(empty($product['rates']))
                        <div class="alert alert-warning">In currently product don't have a reviews.</div>
                        @else
                        <div style="overflow-y: auto; max-height: 200px;">
                            @foreach($product['rates'] as $rate)
                            <div class="media">
                                <div class="media-body">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <h5 class="media-heading"><strong>{{$rate['user']['name']}}</strong></h5>
                                        </div>
                                        <div class="col-md-2 product-rating">
                                            @for($i = 0; $i < 5; $i++ , $rate['rate']--)
                                            @if($rate['rate'] >= 1)
                                            <i class="fa fa-star"></i>
                                            @elseif($rate['rate'] === 0.5)
                                            <i class="fa fa-star-half-o"></i>
                                            @else
                                            <i class="fa fa-star-o"></i>
                                            @endif
                                            @endfor
                                        </div>
                                    </div>
                                    {{$rate['review']}}
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                        @if(!empty($user_id))
                        <hr/>
                        <h4 class="m-b-2">Add your review</h4>
                        <form role="form" method="post" action="{{url('shop/add-rate')}}">
                            {{ csrf_field() }}
                            <input type="hidden" name="user_id" value="{{$user_id}}">
                            <input type="hidden" name="product_id" value="{{$product['id']}}">
                            <input type="hidden" name="back" value="{{$back}}">
                            <div class="form-group">
                                <label>Rating</label><div class="clearfix"></div>
                                <div class="input-rating"></div>
                            </div>
                            <div class="form-group">
                                <label for="Review">Your Review</label>
                                <textarea id="Review" class="form-control" rows="5" placeholder="Your Review" name='review'></textarea>
                            </div>
                            <button type="submit" class="btn btn-theme">Submit Review</button>
                        </form>
                        @endif
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