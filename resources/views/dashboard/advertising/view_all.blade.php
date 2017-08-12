@extends('layout.dashboard')

@section('content')
<div class="form-group">
</div>

@if(!empty($advertisings))
<form method="GET" action="" style="margin-bottom: 15px;">
    <div class="input-group">
        <div class="input-group-btn">
            <a class="btn btn-primary" href="{{url('dashboard/advertisings/create')}}" data-toggle="tooltip" data-placement="top" title="Add Advertising">
                <span class="fa fa-plus"></span> Advertising
            </a>
            @if(!empty($request->find))
            <a href="{{url('dashboard/advertisings')}}" type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Clear Search"><i class="fa fa-close"></i></a>
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
    @foreach($advertisings as $adv)
    <tr>
        <td>{{$adv['title']}}</td>
        <td>{{$adv['url']}}</td>
        <td>{{$adv['created_at']}}</td>
        <td>{{$adv['updated_at']}}</td>
        <td>
            <div class="btn-group btn-group-xs" role="group">
                <a href="{{url('dashboard/advertisings/'.$adv['id']) .'/edit'}}" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="Edit">
                    <span class="fa fa-edit"></span>
                </a>
                <a href="#" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete" data-route="{{'dashboard/advertisings/' . $adv['id'] }}" data-msg="Did you want to delete ({{$adv['title']}}) category">
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