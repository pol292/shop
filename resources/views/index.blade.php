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
                <div class="widget-slider owl-carousel owl-theme owl-controls-top-offset m-b-2 new-product">
                    @each('shop.skin.product_slider', $new_product, 'product')
                </div>
            </div>
        </div>
        <!-- End Vertical Menu -->

        <div class="clearfix visible-sm visible-xs"></div>

        <div class="col-md-9">

            <!-- Featured -->
            <div class="title"><span>Sale</span></div>

            @each('shop.skin.product_list', $sale_product, 'product')

            <!-- End Featured -->
            <div class="clearfix"></div>

            <!-- Collection -->
            <div class="title m-t-2"><span>Random Items</span></div>
            <div class="product-slider owl-carousel owl-theme owl-controls-top-offset">
                @each('shop.skin.product_slider', $random_list_product, 'product')
            </div>
        </div>

    </div>
</div>
<!-- End Main Content -->

@endsection