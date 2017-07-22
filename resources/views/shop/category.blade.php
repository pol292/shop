@extends('layout.main')
@section('content')
<!-- Main Content -->
<div class="container m-t-3">
    <div class="row">
        <!-- Filter Sidebar -->
        <div class="col-sm-3 hidden-xs">
            <form method="GET">
                <div class="filter-sidebar">
                    <div class="title"><span>Sort By</span></div>
                    <ul>
                        <li>
                            <select name="sort" class="selectpicker" data-width="100%">
                                <option @if($request['sort'] == 0) selected="selected" @endif value="0">Recomended</option>
                                <option @if($request['sort'] == 'lth') selected="selected" @endif value="lth">Low Price » High Price</option>
                                <option @if($request['sort'] == 'htl') selected="selected" @endif value="htl">High Price » High Price</option>
                            </select>
                        </li>
                    </ul>
                </div>

                <div class="filter-sidebar">
                    <div class="title"><span>Show per page</span></div>
                    <ul>
                        <li>
                            <select name="spg" class="selectpicker" data-width="100%">
                                <option @if($request['spg'] == 4) selected="selected" @endif value="4">4</option>
                                <option @if($request['spg'] == 8) selected="selected" @endif value="8">8</option>
                                <option @if($request['spg'] == 12) selected="selected" @endif value="12">12</option>
                                <option @if($request['spg'] == 16) selected="selected" @endif value="16">16</option>
                                <option @if($request['spg'] == 20) selected="selected" @endif value="20">20</option>
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
            <div class="container-fluid">
                <div class="row filter-sidebar">
                    <article>
                        <h1 class="title"><span>{{$cat['title']}}</span></h1>
                        <div class="alert alert-color">{{$cat['article']}}</div>
                    </article>
                </div>

                @if(empty($cat['products']))
                <div class="alert alert-warning">
                    There are no products in {{$cat['title']}} category.
                </div>
                @else
                @for($i = 0 , $c = 1, $end = count($cat['products']) ; $i < $end ; $i++, ($c === 4? $c = 1 : $c++ ) )
                
                @php 
                $product = $cat['products'][$i];
                $product['category']  = &$cat;
                @endphp
                
                @include('shop.skin.product_list')

                @if($c === 2)
                <div class="clearfix visible-xs visible-sm"></div>
                @elseif($c === 4)
                <div class="clearfix"></div>
                @endif


                @endfor

                @endif
            </div>
        </div>
        <!-- End Product List -->

    </div>
</div>

<script>
    var rates = {
    'min': {{empty($rates['minValue'])? 0 : $rates['minValue']}},
            'max': {{empty($rates['maxValue'])? 0 : $rates['maxValue']}}
    };
    var current_rate = [
    {{empty($request['min-price'])? $rates['minValue']: $request['min-price']}},
    {{empty($request['max-price'])? $rates['maxValue']: $request['max-price']}}
    ];
</script>
<!-- End Main Content -->
@endsection