@extends('layout.dashboard')

@section('content')
<div class="form-group">
</div>

@if(!empty($categories))
<form method="GET" action="" style="margin-bottom: 15px;">
    <div class="input-group">
        <div class="input-group-btn">
            <a class="btn btn-primary" href="{{url('dashboard/shop/category/create')}}" data-toggle="tooltip" data-placement="top" title="Add Category">
                <span class="fa fa-plus"></span> Category
            </a>
            @if(!empty($request->find))
            <a href="{{url('dashboard/shop/category')}}" type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Clear Search"><i class="fa fa-close"></i></a>
            @endif
        </div>
        <input type="text" name="find" class="form-control search-input" aria-label="Search here..." placeholder="Search here..." autocomplete="off" value="{{$request->find}}">
        <div class="input-group-btn">
            <button type="submit" class="btn btn-primary"  data-toggle="tooltip" data-placement="top" title="Search"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>

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