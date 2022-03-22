@extends('Layouts.loginLayout')
@section('pageTitle')
   Welcome To Cooperative Portal
@stop
@section('content')
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
    
      <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one" style="background: url({{asset('assets/images/bg-landing.jpg')}}) no-repeat center top / cover">
        <div class="row w-100 mx-auto">
          <div class="col-lg-4 mx-auto">
            <div align="center" class="text-center text-success">
                    <b><b><big><big>Login To Your Account Now</big></b></b><br /><br />
                    @if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@elseif (session('warnMessage'))
    <div class="alert alert-warning">
        {{ session('warnMessage') }}
    </div>
@elseif (session('errorMessage'))
    <div class="alert alert-danger">
        {{ session('errorMessage') }}
    </div>
@elseif ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
            </div>
            <div class="auto-form-wrapper">
              <form action="{{route('login')}}" method="post">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }} formField">
                  <label class="label">Username</label>
                  <div class="input-group">
                    <input type="text" name="username" class="form-control" placeholder="Enter Username" value="{{ old('username') }}" required autofocus>
                    <div class="input-group-append">
                      <span class="input-group-text"><i class="icon-check"></i></span>
                    </div>
                  </div>
                  @if ($errors->has('username'))
                    <span class="text-danger">
                      <strong>{{ $errors->first('username') }}</strong>
                    </span>
                  @endif
                </div>
                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }} formField">
                  <label class="label">Password</label>
                  <div class="input-group">
                    <input type="password" name="password" class="form-control" placeholder="Enter Password" value="{{old('password')}}" required >
                    <div class="input-group-append">
                      <span class="input-group-text"><i class="icon-check"></i></span>
                    </div>
                  </div>
                   @if ($errors->has('password'))
                      <span class="text-danger">
                          <strong>{{ $errors->first('password') }}</strong>
                      </span>
                  @endif
                </div>
                
                <div class="form-group">
                    <label for="" class="col-md-4 control-label"></label>
                    <div class="col-md-7">
                        <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_CAPTCHA_SITE_KEY') }}"></div>
                        @if ($errors->has('g-recaptcha-response'))
                            <span style="display: block; color:white;">
                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                        
                <div class="form-group">
                  <button class="btn btn-success submit-btn btn-block">Login</button>
                </div>
                <div class="form-group d-flex justify-content-between">
                  <div class="form-check form-check-flat mt-0">
                    <label class="form-check-label">
                      <input type="checkbox" class="form-check-input" checked>
                      Keep me signed in
                    </label>
                  </div>
                  <a href="{{url('/member-application')}}" class="text-small forgot-password text-black" title="Are you a new member? then, click this link to register now">
                    <h4><b>Register Now</b></h4>
                  </a>
                </div>
               </form>
                <div class="form-group">
                  <button class="btn btn-block g-login">Forgot Password</button>
                </div>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
@stop

@section('styles')
<!--//-->
@stop

@section('scripts')
 <!--//-->
@stop