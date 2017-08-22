@extends('layout.main')
@section('content')
<!-- Main Content -->
<div class="container m-t-3">
    <div class="row">

        <!-- Register Form -->
        <div class="col-sm-8 login-register-form m-b-3">
            <div class="title"><span>Create An Account With facebook</span></div>
            <div class="row">
                <form method="post" action="{{url('user/register')}}">
                    {{ csrf_field() }}
                    <input type="hidden" name="facebook" value="{{$facebook['id']}}">
                        <div class="form-group col-sm-6">
                            <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{$facebook['name']}}">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="email">Email address</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Email"  value="{{$facebook['email']}}">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Password">
                        </div>
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-theme"><i class="fa fa-long-arrow-right"></i> Register</button>
                        </div>
                </form>
            </div>
        </div>
        <!-- End Register Form -->

        <!-- Login Form -->
        <div class="col-sm-4">
            <div class="title"><span>Already Registered ?</span></div>
            <form method="post" action="{{url('user/login')}}">
                {{ csrf_field() }}
                <input type="hidden" name="facebook" value="{{$facebook['id']}}">
                <div class="form-group">
                    <label for="emailInputLogin">Email address</label>
                    <input type="text" class="form-control" id="emailInputLogin" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="passwordInputLogin">Password</label>
                    <input type="password" class="form-control" id="passwordInputLogin" name="password" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-theme"><i class="fa fa-long-arrow-right"></i> Login</button>
            </form>
        </div>
        <!-- End Login Form -->

    </div>
</div>
<!-- End Main Content -->
@endsection