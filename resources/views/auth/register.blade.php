@extends('Layouts.adminLayout')

@section('currentMore')
  active
@stop

@section('currentPage')
  Register Now
@stop

@section('pageTitle')
 Register Now
@stop

@section('content')
  <div id="middle" class="container">
            <div class="white">

                    

                    <div class="col-md-9">  

                        <form method="post" action="{{ route('register') }}">
                          <div align="right" class="text-warning">
                            <small>All fields with <i class="text-danger">*</i> are important</small>
                          </div>
                          <div class="box-body" style="border: 1px dotted #ddd; padding: 20px;">
                                <div class="row">
                                    <div class="col-md-12"><!--1st col-->
                                        @if (count($errors) > 0)
                                            <div class="alert alert-danger alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                                                </button>
                                                <strong>Error!</strong> 
                                                @foreach ($errors->all() as $error)
                                                    <p>{{ $error }}</p>
                                                @endforeach
                                            </div>
                                        @endif
                                               
                                        @if(session('msg'))
                                            <div class="alert alert-success alert-dismissible" role="alert">
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                                                </button>
                                                <strong>Success!</strong> 
                                                {{ session('msg') }}
                                            </div>                        
                                        @endif

                                    </div>
                                    {{ csrf_field() }}
                                    
                                        <div class="col-md-12"><!--2nd col-->
                                                        <div class="row">
                                                          <div class="col-md-6">
                                                                <div class="form-group">
                                                                  <label for="firstName">
                                                                    First Name <i class="text-danger">*</i> 
                                                                  </label>
                                                                   <input type="Text" name="firstName" class="form-control" required placeholder="Enter First Name" value="{{old('firstName')}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                  <label for="lastName">
                                                                    Last Name 
                                                                  </label>
                                                                  <input type="Text" name="lastName" class="form-control" placeholder="Enter Last Name" value="{{old('lastName')}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row">
                                                          <div class="col-md-6">
                                                                <div class="form-group">
                                                                  <label for="password">
                                                                    Password <i class="text-danger">*</i>
                                                                  </label>
                                                                  <input type="password" name="password" class="form-control"  placeholder="Enter Password" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                  <label for="password_confirmation"> 
                                                                    Retype Password <i class="text-danger">*</i>
                                                                  </label>
                                                                  <input type="password" name="password_confirmation" class="form-control" placeholder="Retype Password" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                          <div class="col-md-6">
                                                                <div class="form-group">
                                                                  <label for="division"> 
                                                                    Email Address <i class="text-danger">*</i>
                                                                  </label>
                                                                 <input type="email" name="email" class="form-control" placeholder="Enter Email Address" required value="{{old('email')}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                  <label for="gender">
                                                                      Gender <i class="text-danger">*</i>
                                                                  </label>
                                                                  <select name="gender" class="form-control" required>
                                                                    <option value="">Select</option>
                                                                    <option  value="Male" {{ (old("gender") == "Male" ? "selected":"") }}>Male</option>
                                                                    <option  value="Female" {{ (old("gender") == "Female" ? "selected":"") }}>Female</option>
                                                                  </select>
                                                                </div>
                                                            </div>
                                                          </div>

                                                          
                                                          <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                  <label for="mobileNumber">Mobile Number</label>
                                                                  <input type="text" name="mobileNumber" class="form-control"  placeholder="Enter Mobile Number" value="{{old('mobileNumber')}}">
                                                                </div>
                                                            </div>
                                                            
                                                            <input type="hidden" name="referralID" value="{{$referralID}}">
                                                            
                                                            <div class="row">
                                                              <div class="col-md-6">
                                                                  <div class="form-group{{ $errors->has('CaptchaCode') ? ' has-error' : '' }}">
                                                                       {!! captcha_image_html('ContactCaptcha') !!}
                                                                  </div>
                                                              </div>
                                                              <div class="col-md-6">
                                                                  <label>Enter what you see above here <span class="text-danger">*</span></label>
                                                                  <input type="text" id="CaptchaCode" name="CaptchaCode" class="form-control" required />
                                                                  @if ($errors->has('CaptchaCode'))
                                                                      <span class="text-danger">
                                                                          <strong>{{ $errors->first('CaptchaCode') }}</strong>
                                                                      </span>
                                                                  @endif
                                                              </div>
                                                            </div>
                                                        </div>

                                                        <hr />

                                                         <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                  <label for=""></label>
                                                                    <div align="right">
                                                                        <button class="btn btn-success" type="submit"> Create Account</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                          </div>

                                        </div>
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                          </form>

                    </div>
                </div>
            </div>
        </div>
@stop
