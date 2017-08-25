@extends('layout.dashboard')

@section('content')
<div class="form-group">
</div>

@if(!empty($orders))
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
        <th>User</th>
        <th>Products qty</th>
        <th>Buyed at</th>
        <th>Total</th>
        <th>Actions</th>
    </tr>
    @foreach($orders as $order)
    <tr>
        <td>{{$order['user']['name']}}</td>
        <td>{{$order['count'] . ' Item' . ($order['count'] > 1? 's' : '')}}</td>
        <td>{{$order['created_at']}}</td>
        <td>{{$order['total']}}</td>
        <td>
            <div class="btn-group btn-group-xs" role="group">
                <a href="{{url('dashboard/shop/order/'.$order['id'])}}" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="view">
                    <span class="fa fa-eye"></span>
                </a>
                
            </div>
        </td>
    </tr>
    @endforeach
    <tr>
        <th>User</th>
        <th>Products qty</th>
        <th>Buyed at</th>
        <th>Total</th>
        <th>Actions</th>
    </tr>
</table>
@else
<div class="alert alert-warning">
    You are not have pages in your CMS system
</div>
@endif
@endsection