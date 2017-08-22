@extends('layout.main')
@section('content')
<!-- Main Content -->
<div class="container m-t-3">
    <div class="row">

        <!-- Login Form -->
        <div class="col-sm-6 col-xs-12 login-register-form m-b-3">
            <div class="title"><span>Please Enter Your Information</span></div>
            <form method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="emailInputLogin">Email address</label>
                    <input type="email" class="form-control" id="emailInputLogin" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="passwordInputLogin">Password</label>
                    <input type="password" class="form-control" id="passwordInputLogin" placeholder="Password">
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox"><span> Remember me</span>
                    </label>
                </div>
                <button type="submit" class="btn btn-default btn-theme"><i class="fa fa-long-arrow-right"></i> Login</button>
                <button type="button" class="btn btn-default btn-theme pull-right">Forgot your password ?</button>
            </form>
        </div>
        <!-- End Login Form -->

        <!-- Alternative Login Button -->
        <div class="col-sm-6 col-xs-12">
            <div class="title"><span>Or Login Using</span></div>
            <a href="{{$facebook}}" class="btn btn-primary btn-md"><i class="fa fa-facebook"></i> Facebook</a>
        </div>
        <!-- End Alternative Login Button -->

    </div>
</div>
<!-- End Main Content -->
@endsection