<!--call main layout-->
@extends('Layouts.errorLayout')
<!--call page title-->
@section('pageTitle')
   404 Error Occured - Page Not Found
@endsection
<!--render page content-->
@section('content')

        
      <div class="row align-items-center d-flex flex-row">
            <div class="col-lg-6 text-lg-right pr-lg-4">
                <div align="center" class="display-1 mb-0" style="font-size: 30px;">
                  <small class="text-warning"><b>@yield('pageTitle')</b></small>
              </div>
            </div>
              <div class="col-lg-6 error-page-divider text-lg-left pl-lg-4">
                <h2>SORRY!</h2>
                <h3 class="font-weight-light">The page you’re looking for was not found.</h3>
              </div>
            </div>
          <div class="row mt-5">
            <div class="col-12 text-center mt-xl-2">
              <a class="text-white font-weight-medium" href="{{route('home')}}">Back to home</a>
            </div>
      </div>

@stop
