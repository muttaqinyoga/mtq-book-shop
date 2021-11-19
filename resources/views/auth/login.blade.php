@extends('layouts.app')
@section('title') Login @endsection
@section('content')
<div class="page-content--bge5">
    <div class="container">
        <div class="login-wrap">
            <div class="login-content">
                <div class="login-logo">
                    <a href="#">
                        MUTTAQIN BOOK SHOP
                    </a>
                </div>
                <div class="login-form">
                    @if($message = Session::get('FailedLogin') )
                    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                        <span class="badge badge-pill badge-danger">Failed</span>
                        {{$message}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    @endif
                    <form action="{{url('login')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label class="form-control-label">Email Address</label>
                            <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" type="email" name="email" placeholder="Email" autofocus>
                            @if ($errors->has('email'))
                            <small class="help-block form-text text-danger">{{ $errors->first('email') }}</small>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" name="password" placeholder="Password">
                            @if ($errors->has('email'))
                            <small class="help-block form-text text-danger">{{ $errors->first('password') }}</small>
                            @endif
                        </div>
                        <div class="login-checkbox">
                            <label>
                                <input type="checkbox" name="remember">Remember Me
                            </label>
                            <label>
                                <a href="#">Forgotten Password?</a>
                            </label>
                        </div>
                        <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">sign in</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection