@extends('layout.dashboard')

@section('content')
<div class="form-group">
    <a class="btn btn-primary" href="{{url('dashboard/shop/category/create')}}" data-toggle="tooltip" data-placement="top" title="Add">
        <span class="fa fa-plus"></span> Add Category
    </a>
</div>

@if(!empty($categories))

<table class="table">
    <tr>
        <th>Title</th>
        <th>URL</th>
        <th>Created at</th>
        <th>Updated at</th>
        <th>Actions</th>
    </tr>
    @foreach($categories as $category)
    <tr>
        <td>{{$category['title']}}</td>
        <td>{{$category['url']}}</td>
        <td>{{$category['created_at']}}</td>
        <td>{{$category['updated_at']}}</td>
        <td>
            <div class="btn-group btn-group-xs" role="group">
                <a href="{{url('dashboard/shop/category/'.$category['id']) .'/edit'}}" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Edit">
                    <span class="fa fa-edit"></span>
                </a>
                <a href="#" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete" data-route="{{'dashboard/shop/category/' . $category['id'] }}" data-msg="Did you want to delete ({{$category['title']}}) category">
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