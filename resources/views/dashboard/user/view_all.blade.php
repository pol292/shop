@extends('layout.dashboard')

@section('content')
<div class="form-group">
</div>

@if(!empty($users))
<form method="GET" action="" style="margin-bottom: 15px;">
    <div class="input-group">
        <div class="input-group-btn">
            <a class="btn btn-primary" href="{{url('dashboard/users/create')}}" data-toggle="tooltip" data-placement="top" title="Add Advertising">
                <span class="fa fa-user-plus"></span> User
            </a>
            @if(!empty($request->find))
            <a href="{{url('dashboard/users')}}" type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Clear Search"><i class="fa fa-close"></i></a>
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
        <th>Role</th>
        <th>Created at</th>
        <th>Facebook</th>
        <th>Actions</th>
    </tr>
    @foreach($users as $user)
    <tr>
        <td>{{$user['name']}}</td>
        <td>{{$user['email']}}</td>
        <td>
            @if($user['role'] == 1)
                User
            @elseif($user['role'] == 3)
                Administrator
            @endif
        </td>
        <td>
            @if(empty($user['facebook']))
            <span class="fa fa-times text-danger"></span>
            @else
                <span class="fa fa-check text-success"></span>
            @endif
        </td>
        <td>{{$user['created_at']}}</td>
        <td>
            <div class="btn-group btn-group-xs" role="group">
                <a href="{{url('dashboard/users/'.$user['id']) .'/edit'}}" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Edit">
                    <span class="fa fa-edit"></span>
                </a>
                <a href="#" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete" data-route="{{'dashboard/users/' . $user['id'] }}" data-msg="Did you want to delete ({{$user['name']}}) category">
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