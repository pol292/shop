@extends('layout.dashboard')

@section('content')
<form method="GET" action="" style="margin-bottom: 15px;">
    <div class="input-group">
        <div class="input-group-btn">
            <a class="btn btn-primary" href="{{url('dashboard/shop/product/create')}}" data-toggle="tooltip" data-placement="top" title="Add Product">
                <span class="fa fa-plus"></span> Product
            </a>
            @if(!empty($request->find))
            <a href="{{url('dashboard/shop/product')}}" type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Clear Search"><i class="fa fa-close"></i></a>
            @endif
        </div>
        <input type="text" name="find" class="form-control search-input" aria-label="Search here..." placeholder="Search here..." autocomplete="off" value="{{$request->find}}">
        <div class="input-group-btn">
            <button type="submit" class="btn btn-primary"  data-toggle="tooltip" data-placement="top" title="Search"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>

@if(!empty($products))

<table class="table">
    <tr>
        <th></th>
        <th>Title</th>
        <th>Price</th>
        <th>Stock</th>
        <th>URL</th>
        <th>Updated at</th>
        <th>Actions</th>
    </tr>
    @foreach($products as $product)
    <tr>
        @if(empty($product['image']))
            <td><img src="{{asset("images/empty.png")}}" height="50" alt="{{$product['title']}}"></td>
        @else
            <td><img src="{{asset("images/up/{$product['image']}")}}" height="50" alt="{{$product['title']}}"></td>
        @endif
        <td  style="vertical-align: middle;">{{$product['title']}}</td>
        <td  style="vertical-align: middle;">
            @if(empty((float)$product['sale']))
            ${{$product['price']}}
            @else
            <div class="text-success">${{$product['price']*(1-$product['sale']/100)}}</div>
            <div class="text-danger"><del>${{$product['price']}}</del></div>
            <div class="label label-default">-{{$product['sale']}}%</div>
            @endif
        </td>
        <td class="text-center"  style="vertical-align: middle;">{{$product['stock']}}</td>
        <td  style="vertical-align: middle;">{{$product['url']}}</td>
        <td  style="vertical-align: middle;">{{$product['created_at']}}</td>
        <td  style="vertical-align: middle;">
            <div class="btn-group btn-group-xs" role="group">
                <a href="{{url('dashboard/shop/product/'.$product['id']) .'/edit'}}" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Edit">
                    <span class="fa fa-edit"></span>
                </a>
                <a href="#" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete" data-route="{{'dashboard/shop/product/' . $product['id'] }}" data-msg="Did you want to delete ({{$product['title']}}) product">
                    <span class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></span>
                </a>
            </div>
        </td>
    </tr>
    @endforeach
    <tr>
        <th></th>
        <th>Title</th>
        <th>Price</th>
        <th>Stock</th>
        <th>URL</th>
        <th>Updated at</th>
        <th>Actions</th>
    </tr>
</table>
@else
<div class="alert alert-warning">
    You are not have pages in your CMS system
</div>
@endif
@endsection