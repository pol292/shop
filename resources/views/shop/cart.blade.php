@extends('layout.main')
@section('content')
<!-- Main Content -->

<div class="row">

    <!-- Shopping Cart List -->
    <div class="col-md-9">
        <div class="title"><span>My Shopping Cart</span></div>
        <div id='cart-show' class="table-responsive">
            @if(Cart::count())
            <table class="table table-bordered table-cart">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Unit price</th>
                        <th>SubTotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(Cart::content()->toArray() as $inCart)
                    <tr>
                        <td class="img-cart">
                            <a href="{{$inCart['options']['url']}}">
                                <img alt="Product" src="{{asset("images/up/{$inCart['options']['image']}")}}" class="img-thumbnail">
                            </a>
                        </td>
                        <td style="vertical-align: middle;">
                            <p><a href="{{$inCart['options']['url']}}" class="d-block">{{$inCart['name']}}</a></p>
                        </td>
                        <td class="input-qty"><input type="text" value="{{$inCart['qty']}}" data-rowid='{{$inCart['rowId']}}' class="form-control text-center cart-qty" /></td>
                        <td class="unit text-center" style="vertical-align: middle;">${{round($inCart['price'],2)}}</td>
                        <td class="sub text-center" style="vertical-align: middle;">${{round($inCart['subtotal'],2)}}</td>
                        <td class="action text-center" style="vertical-align: middle;">
                            <a href="#" class="text-danger remove-from-cart" data-rowid="{{$inCart['rowId']}}" data-toggle="tooltip" data-placement="top" data-original-title="Remove"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" class="text-right">Total</td>
                        <td colspan="2"><b>${{Cart::total()}}</b></td>
                    </tr>
                </tbody>
            </table>
            @else
            <div class="alert alert-warning">
                Don't have products in cart
            </div>
            @endif
        </div>
        <nav aria-label="Shopping Cart Next Navigation">
            <ul class="pager">
                <li class="previous"><a href="{{url('/')}}"><span aria-hidden="true">&larr;</span> Continue Shopping</a></li>
                <li class="next"><a href="checkout.html">Proceed to Checkout <span aria-hidden="true">&rarr;</span></a></li>
            </ul>
        </nav>
    </div>
    <!-- End Shopping Cart List -->

    <!-- New Arrivals -->
    <div class="col-md-3 hidden-sm hidden-xs">
        <div class="title"><span><a href="products.html">New Arrivals <i class="fa fa-chevron-circle-right"></i></a></span></div>
        <div class="widget-slider owl-carousel owl-theme owl-controls-top-offset">
            @each('shop.skin.product_slider', $new_product, 'product')
        </div>
    </div>
    <!-- End New Arrivals -->

</div>

<!-- End Main Content -->
@endsection