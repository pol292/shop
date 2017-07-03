@extends('layout.dashboard')

@section('add_page')
<div class="form-group">
    <a class="btn btn-primary" href="{{url('dashboard/CMS/page/create')}}" data-toggle="tooltip" data-placement="top" title="Add">
        <span class="fa fa-plus"></span> Add page
    </a>
</div>
@endsection
@section('content')
@yield('add_page')
@if(!empty($cms_pages))

<table class="table">
    <tr>
        <th class="text-center">Active</th>
        <th>Title</th>
        <th>URL</th>
        <th>Created at</th>
        <th>Updated at</th>
        <th>Actions</th>
    </tr>
    @foreach($cms_pages as $cms_page)
    <tr>
        <td class="text-center"><span class="fa fa-{{ $cms_page['active']? 'check text-success' : 'times text-danger' }}"</td>
        <td>{{$cms_page['title']}}</td>
        <td>{{$cms_page['url']}}</td>
        <td>{{$cms_page['created_at']}}</td>
        <td>{{$cms_page['updated_at']}}</td>
        <td>
            <div class="btn-group btn-group-xs" role="group">
                <a href="{{url('dashboard/CMS/page/' . $cms_page['url'])}}" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="View"><span class="fa fa-eye"></span></a>
                <a href="{{url('dashboard/CMS/page/'.$cms_page['id']) .'/edit'}}" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Edit">
                    <span class="fa fa-edit"></span>
                </a>
                <a href="#" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete" data-route="{{'dashboard/CMS/page/' . $cms_page['id'] }}" data-msg="Did you want to delete ({{$cms_page['title']}}) page">
                    <span class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></span>
                </a>
            </div>
        </td>
    </tr>
    @endforeach
    <tr>
        <th class="text-center">Active</th>
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
@yield('add_page')
@endsection