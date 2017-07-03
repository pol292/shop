@extends('layout.dashboard')

@section('content')
@if(!empty($historys))

<table class="table">
    <tr>
        <th>Change</th>
        <th>Description</th>
        <th>Updated at</th>
        <th class="text-center">Actions</th>
    </tr>
    @foreach($historys as $history)
    <tr>
        <td>@if(!empty($history['icon']))<span class="fa fa-{{$history['icon']}}"></span>@endif &nbsp; {{ucfirst($history['change'])}}</td>
        <td>{{$history['description']}}</td>
        <td>{{$history['updated_at']}}</td>
        <td class="text-center">
            <a href="{{url('dashboard/restore/view/'.$history['id']) }}" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="top" title="View">

                <span class="fa fa-eye"></span>
            </a> 
        </td>
    </tr>
    @endforeach
    <tr>
        <th>Change</th>
        <th>Description</th>
        <th>Updated at</th>
        <th class="text-center">Actions</th>
    </tr>
    
</table>
@else
    <div class="alert alert-warning">
        You Are not have backup for {{$type}}
    </div>
@endif
@endsection