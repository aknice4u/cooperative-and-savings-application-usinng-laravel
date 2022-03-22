@extends('layouts.layout')
@section('pageTitle')
  Edit User Account
@endsection

@section('content')
  <form method="post" action="{{ url('/user/editAccount') }}">

  <div class="box-body">
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
                                          <label for="userName">Full name</label>
                                           <input type="Text" name="fullName" class="form-control" value="{{ Auth::user()->name }}">
                                        </div>
                                  </div><div class="col-md-6">
                                        <div class="form-group">
                                          <label for="userName">User Name</label>
                                          <input type="Text" name="userName" class="form-control" value="{{ Auth::user()->username }}" readonly>
                                        </div>
                                    </div>
                                 
                                </div>
                                
                                <div class="row">
                                 <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="division">Password</label>
                                          <input type="password" name="password" class="form-control">
                                        </div>
                                  </div>  
                                  
                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="password">Confirm Password</label>
                                          <input type="password" name="password_confirmation" class="form-control">
                                        </div>
                                    </div>
                                  </div>
                                    <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="password">Email Address</label>
                                          <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}">
                                        </div>
                                    </div>
                                      <div class="col-md-6 ">
                                          <div class="form-group">
                                              <label for=""></label>
                                              <div align="right">
                                                  <button class="btn btn-success" type="submit"> Save Profile</button>
                                              </div>
                                          </div>
                                      </div>
                                   </div>   
                                
                </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
  </form>
@endsection
