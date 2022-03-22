<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>@yield('pageTitle')</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{asset('assets/vendors/iconfonts/simple-line-icon/css/simple-line-icons.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendors/css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendors/css/vendor.bundle.addons.css')}}">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" />
  @yield('styles')
  <script> var murl = "{{ url('/')}}"; </script>
   <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_horizontal-navbar.html -->
    <nav class="navbar horizontal-layout col-lg-12 col-12 p-0">
      <div class="nav-top flex-grow-1">
        <div class="container d-flex flex-row h-100">
          <div class="text-center navbar-brand-wrapper d-flex align-items-top">
            <a class="navbar-brand brand-logo" href="{{url('/')}}">
                <!--<img src="{{asset('assets/images/logo.svg')}}" alt="logo"/>-->
                <div style="color: white;font-weight: bolder;"><b><big> COOPERATIVE SYSTEM</big></b></div>
            </a>
            <a class="navbar-brand brand-logo-mini" href="index-2.html">
                <!--<img src="{{asset('assets/images/logo-mini.svg')}}" alt="logo"/>-->
                <div style="color: white;font-weight: bolder;"><b><big> CS</big></b></div>
            </a>
          </div>
          <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            <ul class="navbar-nav navbar-nav-right mr-0">
              <li class="nav-item nav-profile">
                <a class="nav-link" href="#">
                  <span class="nav-profile-text">Welcome Guest! Login To You Account Now</span>
                  <span class="rounded-circle" alt="profile" style="border: 1px solid white; padding: 6px;"><i class="icon icon-user"></i></span>
                </a>
              </li>
            </ul>
            <button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="icon-menu text-white"></span>
            </button>
          </div>
        </div>
      </div>
      <!--<div class="nav-bottom">
        <div class="container">
          <div align="center">
                <div align="center" class="text-center" style="color: green;">
                    <b><b><big><big>Login To Your Account Now</big></b></b>
                </div>
          </div>
        </div>
      </div>-->
    </nav>
        <!--Content-->
         @yield('content')  
        <!--content-->

        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="w-100 clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">
              Developed and Powered by MBR Computers Consultants Limited
            </span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
               Copyright &copy;  Cooperative Members <i class="icon-user"></i> {{date('Y')}}. All Rights Reserved.
              <i class="icon-check text-danger"></i></span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="{{asset('assets/vendors/js/vendor.bundle.base.js')}}"></script>
  <script src="{{asset('assets/vendors/js/vendor.bundle.addons.js')}}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="{{asset('assets/js/template.js')}}"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="{{asset('assets/js/dashboard.js')}}"></script>
  <script src="{{asset('assets/js/todolist.js')}}"></script>
  <!-- End custom js for this page-->
  @yield('scripts')
</body>
</html>
