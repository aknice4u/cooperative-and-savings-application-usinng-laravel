@extends('Layouts.layoutSelector')
@section('pageTitle')
   {{ucwords(auth::user()->name)}}, Account
@stop
@section('content')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            
           <div class="col-md-12 col-xs-12 col-ms-12 grid-margin grid-margin-md-0 stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title nav-link text-center"><b>Edit Account</b></h4>
                  <!--Your contents go thus...-->

                       <div class="row">
                        <div class="col-md-6 offset-md-3 grid-margin stretch-card">
                          <div class="card">
                            @include('PartialView.operationCallBackAlert') <br /><br />
                            <div class="card-body">
                              <p class="card-description">
                                Update Your Password
                              </p>
                              <form class="forms-sample" action="{{route('postEditAccount')}}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                  <label for="exampleInputPassword1">Password</label>
                                  <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
                                </div>
                                <div class="form-group">
                                  <label for="exampleInputConfirmPassword1">Confirm Password</label>
                                  <input type="password" name="password_confirmation" class="form-control" id="exampleInputConfirmPassword1" placeholder="Password" required>
                                </div>
                                <button type="submit" class="btn btn-success mr-2">Update</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>

                  <!--//-->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<!-- content-wrapper ends -->
@stop

@section('styles')
<!--//-->
@stop

@section('scripts')
 <!--//-->
@stop