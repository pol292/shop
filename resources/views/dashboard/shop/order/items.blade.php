@extends('layout.dashboard')

@section('content')
<div class="form-group">
</div>

<a href="{{url('dashboard/shop/order')}}" class="btn btn-default">Back to orders</a>
@if(!empty($order['orders']))
<table class="table">
    <thead>
        <tr>
            <td></td>
            <td>Product Name</td>
            <td>Qty</td>
            <td>price</td>
        </tr>
    </thead>
    <tbody>
        @foreach($order['orders'] as  $item)
        <tr>
            <td><img src="{{asset('images/up/'.$item['options']['image'])}}" alt="{{$item['name']}}" height="50"></td>
            <td><a href="{{url($item['options']['url'])}}">{{$item['name']}}</span></td>
            <td>
                {{$item['qty'] . ' item' . ($item['qty'] == 1? '':'s')}}
            </td>
            <td>{{$item['price']}}</td>
        </tr>
        @endforeach
    </tbody>
    <tr>
        <td></td>
        <td>Product Name</td>
        <td>Qty</td>
        <td>price</td>
    </tr>

</table>
<h3>Total: <small>${{$order['total']}}</small></h3>

@else
<div class="alert alert-warning">
    You are not have pages in your CMS system
</div>
@endif
<a href="{{url('dashboard/shop/order')}}" class="btn btn-default">Back to orders</a>
@endsection