@extends('layout.dashboard')

@section('content')
<div class="form-group">
    <a class="btn btn-primary" href="{{url('dashboard/shop/product/create')}}" data-toggle="tooltip" data-placement="top" title="Add">
        <span class="fa fa-plus"></span> Add Category
    </a>
</div>

@if(!empty($products))

<table class="table">
    <tr>
        <th>Title</th>
        <th>URL</th>
        <th>Created at</th>
        <th>Updated at</th>
        <th>Actions</th>
    </tr>
    @foreach($products as $product)
    <tr>
        <td>{{$product['title']}}</td>
        <td>{{$product['url']}}</td>
        <td>{{$product['created_at']}}</td>
        <td>{{$product['updated_at']}}</td>
        <td>
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
        <th>Title</th>
        <th>URL</th>
        <th>Created at</th>
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