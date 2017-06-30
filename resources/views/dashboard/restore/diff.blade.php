@extends('layout.dashboard')    
@section('btns')
<div style="margin: 15px 0;">
    <a href="{{$back }}" class="btn btn-default pull-left" data-toggle="tooltip" data-placement="top" title="Back">
        <span class="fa fa-arrow-left"></span> Back
    </a>
    @if($diff)
    <a href="{{url('dashboard/restore/'.$id) }}" class="btn btn-primary pull-right" data-toggle="tooltip" data-placement="top" title="Restore">
        <span class="fa fa-history"></span> Restore
    </a>
    @endif
    <div class="clearfix"></div>
</div>
@endsection

@section('content')
<link href="{{asset('css/dashboard/diff.css')}}" rel="stylesheet">

<div class="row">
    @yield('btns')
    @if($diff)
    {!! $diff !!}
    @else
    <div class="alert alert-warning">
        No Different with current version.
    </div>
    @endif
    @yield('btns')
</div>

@endsection