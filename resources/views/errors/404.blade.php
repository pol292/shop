@extends('layout.main')
@section('content')
    <div class="col-xs-12 text-center">
        <div class="alert alert-color">
            <h1><i class="fa fa-sitemap"></i> 404 Page Not Found</h1>
            <h2>The page you were looking for doesn't exist.</h2>
            <div class="btn-group m-t-2 m-b-3" role="group" aria-label="Default button group">
                <a href="javascript:history.back()" class="btn btn-theme"><i class="ace-icon fa fa-arrow-left"></i> Go Back</a>
                <a href="{{url('/')}}" class="btn btn-theme"><i class="ace-icon fa fa-home"></i> Home</a>
            </div>
            <p>Think this is an error? Please <a href="contact.html"><u>let us know.</u></a></p>
        </div>
    </div>
@endsection