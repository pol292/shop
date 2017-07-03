@extends('layout.dashboard')    
@section('btns')
<div style="margin: 15px 0;">
    <a href="{{ url("dashboard/restore/history/$back") }}" class="btn btn-default pull-left" data-toggle="tooltip" data-placement="top" title="Back">
        <span class="fa fa-arrow-left"></span> Back
    </a>
    @if(!empty($differences))
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
    @if(!empty($differences))
    <div class="panel panel-primary">
        <div class="panel-heading">HTML Difference</div>
        <div class="panel-body" style="padding: 0;">
            {!! $differences !!}
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading">View Difference</div>
        <div class="panel-body" style="background-color: #f1f8ff">
            <div class="row">
                @if(!empty($diff))
                @foreach($diff as $key => $p)
                <div class="col-md-6">
                    <div class="panel @if($key == 'old') panel-danger @else panel-success @endif ">
                        <div class="panel-heading">{{ucfirst($key)}}</div>
                        <div class="panel-body">
                            {!! $p !!}
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
    @else
    <div class="alert alert-warning">
        No Different with current version.
    </div>
    @endif

    @yield('btns')
</div>

@endsection