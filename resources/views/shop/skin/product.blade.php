@php
$color = ['danger', 'success', 'info', 'primary'];
@endphp
<div class="img-wrapper">

    @if(empty($product['image']))
        <a href="{{url("shop/{$product['category']['url']}/{$product['url']}")}}">
            <img src="{{asset('images/empty.png')}}" alt="Empty image">
        </a>
    @else
        <a href="{{url("shop/{$product['category']['url']}/{$product['url']}")}}">
            <img alt="{{$product['title']}}" src="{{asset("images/up/{$product['image']}")}}" height="150">
        </a>
    @endif
    @if(!empty((float) $product['sale']))
    <div class="tags">
        <span class="label-tags">
            <a href="{{url("shop/{$product['category']['url']}/{$product['url']}")}}">
                <span class="label label-default arrowed">-{{$product['sale']}}%</span>
            </a>
        </span>
    </div>
    <div class="tags tags-left">
        <span class="label-tags">
            <a href="{{url("shop/{$product['category']['url']}/{$product['url']}")}}">
                <span class="label label-{{$color[array_rand($color)]}} arrowed-right">Sale</span>
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
<h6><a href="{{url("shop/{$product['category']['url']}/{$product['url']}")}}">{{$product['title']}}</a></h6>
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
<div class="rating">
    <i class="fa fa-star"></i>
    <i class="fa fa-star"></i>
    <i class="fa fa-star"></i>
    <i class="fa fa-star"></i>
    <i class="fa fa-star-half-o"></i>
    <a href="#">(5 reviews)</a>
</div>