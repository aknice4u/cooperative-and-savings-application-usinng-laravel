<!DOCTYPE html>
<html>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <title>@yield('pageTitle')</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{asset('assets/vendors/iconfonts/simple-line-icon/css/simple-line-icons.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendors/css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendors/css/vendor.bundle.addons.css')}}">
  <link rel="stylesheet" href="{{asset('assets/datatables.css')}}">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('assets/css/test.css')}}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" />
  @yield('styles')
  <script> var murl = "{{ url('/')}}"; </script>
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_horizontal-navbar.html -->
    <nav class="navbar horizontal-layout col-lg-12 col-12 p-0">
      <div class="nav-top flex-grow-1" style="background:#00b297 !important;">
        <div class="container d-flex flex-row h-100">
          <div class="text-center navbar-brand-wrapper d-flex align-items-top">
            <a class="navbar-brand brand-logo" href="{{route('home')}}">
                <!--<img src="{{asset('assets/images/logo.png')}}" alt=" "/>-->
                <div style="color: white;font-weight: bolder;"><b><big> COOPERATIVE SYSTEM</big></b></div>
            </a>
            <a class="navbar-brand brand-logo-mini" href="{{route('home')}}">
                <!--<img src="{{asset('assets/images/logo-mini.png')}}" alt=" "/>-->
                <div style="color: white;font-weight: bolder;"><b><big>COOP</big></b></div>
            </a>
          </div>
          <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            <!--<form class="search-field" action="#">
              <div class="form-group mb-0">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="search">
                  <div class="input-group-append">
                    <span class="input-group-text"><i class="icon-magnifier"></i></span>
                  </div>
                </div>
              </div>
            </form>-->
            <ul class="navbar-nav navbar-nav-right mr-0">
              @include('PartialView.notification')
              <li> <b>Welcome To Admin Portal</b> &nbsp;&nbsp;  | </li>
              <li class="nav-item nav-profile dropdown">
                <a class="nav-link" href="#" id="accountDropdown" data-toggle="dropdown">
                  <span class="nav-profile-text">Hello {{Auth::user()->name}}</span>
                  <span class="rounded-circle" alt="profile" style="border: 1px solid white; padding: 6px;"><i class="icon icon-user"></i></span>
                </a>
                <div class="dropdown-menu dropdown-menu-left navbar-dropdown preview-list" aria-labelledby="accountDropdown">
                  <a href="{{route('editAccount')}}" class="dropdown-item py-3">
                    <p class="mb-0 font-weight-medium float-left">Edit Account</p>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a href="{{route('logout')}}" class="dropdown-item py-3">
                    <p class="mb-0 font-weight-medium float-left">Logout</p>
                  </a>
                </div>
              </li>

            </ul>
            <button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="icon-menu text-white"></span>
            </button>
          </div>
        </div>
      </div>
      <div class="nav-bottom">
        <div class="container">
          <ul class="nav page-navigation">

            <li class="nav-item">
              <a href="{{route('home')}}" class="nav-link">
                <i class="link-icon icon-screen-desktop"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="link-icon icon-user-following"></i>
                <span class="menu-title">Member Profile</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="submenu">
                <ul class="submenu-item">
                  <li class="nav-item"><a class="nav-link" href="{{route('regMember')}}">Member Registration</a></li>
                  <li class="nav-item"><a class="nav-link" href="{{route('editProfile')}}">Edit Profile</a></li>
                  <li class="nav-item"><a class="nav-link" href="{{route('getApplicants')}}">Applicants</a></li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="link-icon icon-book-open"></i>
                <span class="menu-title">Transaction</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="submenu">
                <ul class="submenu-item">
                  <li class="nav-item"><a class="nav-link" href="{{url('/loan-requests/list')}}">Loan Approval</a></li>
                   <li class="nav-item"><a class="nav-link" href="{{url('/loan-request/secretary')}}">Secretary Loan Request Vetting </a></li>
                   <li class="nav-item"><a class="nav-link" href="{{url('/loan-request/treasurer')}}">Treasurer Loan Request Vetting </a></li>
                  <li class="nav-item"><a class="nav-link" href="/monthly/contribution">Month Contribution</a></li>
                  <li class="nav-item"><a class="nav-link" href="{{url('/epayment/report')}}">E-Payment</a></li>
                  <li class="nav-item"><a class="nav-link" href="/payment-transaction">Payment Transaction</a></li>
                  <li class="nav-item"><a class="nav-link" href="#">Contribution Adjustment</a></li>
                  <li class="nav-item"><a class="nav-link" href="/edit-contrib-approve">Confirm Change of monthly contributions</a></li>
                  <li class="nav-item"><a class="nav-link" href="/loan-request/add">Create Loan Request</a></li>
                  
                </ul>
              </div>
            </li>

             <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="link-icon icon-book-open"></i>
                <span class="menu-title">Report</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="submenu">
                <ul class="submenu-item">
                  <li class="nav-item"><a class="nav-link" href="/member-transaction/report">Member Transaction</a></li>
                  <li class="nav-item"><a class="nav-link" href="{{url('/loan-history/list')}}">Loan Collection history</a></li>
                  <li class="nav-item"><a class="nav-link" href="/monthly/contribution-report">Monthly Contribution</a></li>
                  <li class="nav-item"><a class="nav-link" href="{{url('/epayment/view-batch')}}">E-Payment</a></li>
                  <li class="nav-item"><a class="nav-link" href="/member-summary/report">Member Balance</a></li>
                  <li class="nav-item"><a class="nav-link" href="/archive/report">Archive Transaction</a></li>
                  
                </ul>
              </div>
            </li>
            
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="link-icon icon-user-following"></i>
                <span class="menu-title">Member</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="submenu">
                <ul class="submenu-item">
                  <li class="nav-item"><a class="nav-link" href="/member-portal">Member Information</a></li>
                  <li class="nav-item"><a class="nav-link" href="{{ route('createCommittee') }}">Management Committee</a></li>
                </ul>
              </div>
            </li>
            
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="link-icon icon-book-open"></i>
                <span class="menu-title">Set-up</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="submenu">
                <ul class="submenu-item">
                  <li class="nav-item"><a class="nav-link" href="/bank-details">Banks</a></li>
                  <li class="nav-item"><a class="nav-link" href="/division">Divisions</a></li>
                  <li class="nav-item"><a class="nav-link" href="/salary/record">Contribution from Salary</a></li>
                  <li class="nav-item"><a class="nav-link" href="{{route('addBankDetails')}}">COOP Bank Details</a></li>
                  <li class="nav-item"><a class="nav-link" href="/edit-rate">Edit Interest Rate</a></li>
                </ul>
              </div>
            </li>

             <li class="nav-item">
              <a href="{{route('logout')}}" class="nav-link">
                <i class="link-icon icon-logout"></i>
                <span class="menu-title">Logout</span>
              </a>
            </li>

            <li class="nav-item"><a href="#" class="nav-link"></a></li>
            <li class="nav-item"><a href="#" class="nav-link"></a></li>
            <li class="nav-item"><a href="#" class="nav-link"></a></li>
            <li class="nav-item"><a href="#" class="nav-link"></a></li>
            <li class="nav-item"><a href="#" class="nav-link"></a></li>
            <li class="nav-item"><a href="#" class="nav-link"></a></li>
            <li class="nav-item"><a href="#" class="nav-link"></a></li>

          </ul>
        </div>
      </div>
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
  <script src="{{asset('assets/js/modal-demo.js')}}"></script>
  <script src="{{asset('assets/js/data-table.js')}}"></script>
  <script src="{{asset('assets/datatables.js')}}"></script>
  @yield('scripts')
  <!-- End custom js for this page-->
</body>
</html>
