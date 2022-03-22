@extends('Layouts.layoutSelector')
@section('pageTitle')
   Welcome To Cooperative Portal
@stop
@section('welcomePageActive')
  active
@stop
@section('content')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-6 col-lg-3 grid-margin stretch-card">
              <div class="card bg-dark text-white border-0">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <i class="icon-calendar icon-lg"></i>
                    <div class="ml-4">
                      <h4 class="font-weight-light">Last Login</h4>
                      <p class="mb-0 font-weight-light">{{ Session::get('lastLogin') }}</p>
                      <p class="mb-0 font-weight-light">
                         <small>Login At: {{ Session::get('currentlogin') }}</small>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-3 grid-margin stretch-card">
              <div class="card bg-primary text-white border-0">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <i class="icon-user icon-lg"></i>
                    <div class="ml-4">
                      <h4 class="font-weight-light">My Last Contribution</h4>
                      <h3 class="font-weight-light mb-3">&#8358; {{ number_format($myLastContribution, 2, '.', ',') }}</h3>
                      <p class="mb-0 font-weight-light">Till Date: 00-00-00</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-6 col-lg-3 grid-margin stretch-card">
              <div class="card bg-success text-white border-0">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <i class="icon-support icon-lg"></i>
                    <div class="ml-4">
                      <h4 class="font-weight-light">My Total Savings</h4>
                      <h3 class="font-weight-light mb-3">&#8358; {{ number_format($myTotalSavings, 2, '.', ',') }}</h3>

                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-3 grid-margin stretch-card">
              <div class="card bg-danger text-white border-0">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <i class="icon-screen-desktop icon-lg"></i>
                    <div class="ml-4">
                      <h4 class="font-weight-light">Last Loan Borrowed</h4>
                      <h3 class="font-weight-light mb-3">&#8358; {{ number_format($myLastLoan->amount, 2, '.', ',') }}</h3>
                      <p class="mb-0 font-weight-light">Pay Back Rate: {{$myLastLoan->loan_rate}} %</p>
                      <p class="mb-0 font-weight-light">Date: {{$myLastLoan->approved_date}} </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
       
          <div class="row">
              <div class="col-md-4 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex align-items-center">
                        <div class="icon-in-bg bg-success text-white rounded-circle">
                          <i class="icon-tag font-weight-bold"></i>
                        </div>
                        <div class="ml-4">
                          <h4> Outstanding Unpaid Loan </h4>
                          <h3 class="mb-0 font-weight-medium">&#8358; {{ number_format($myOutstandings->unpaidloan, 2, '.', ',') }}</h3>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="col-md-4 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex align-items-center">
                        <div class="icon-in-bg bg-primary text-white rounded-circle">
                          <i class="icon-basket font-weight-bold"></i>
                        </div>
                        <div class="ml-4">
                          <h4> Outstanding Unpaid Interest </h4>
                          <h3 class="mb-0 font-weight-medium">&#8358; {{ number_format($myOutstandings->unpaidinterest, 2, '.', ',')}}</h3>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="col-md-4 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex align-items-center">
                        <div class="icon-in-bg bg-primary text-white rounded-circle">
                          <i class="icon-basket font-weight-bold"></i>
                        </div>
                        <div class="ml-4">
                          <h4> Outstanding Amount To Be Paid </h4>
                          <h3 class="mb-0 font-weight-medium">&#8358; {{ number_format(($myOutstandings->unpaidloan + $myOutstandings->unpaidinterest), 2, '.', ',')}}</h3>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
            </div>

            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title"><b>OUR BANK DETAILS</b></h4>
                        @if(count($getAllBanks) > 0)
                        @foreach($getAllBanks as $listBank)
                           <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                              <div class="card-body">
                                  <ul>
                                    <li>
                                        <h6><b>A/C Name:</b>
                                          {{$listBank->account_name}}
                                       </h6>
                                    </li>
                                    <li>
                                        <h6><b>Bank Name:</b> 
                                          {{$listBank->bank_name}}
                                        </h6>
                                    </li>
                                    <li>
                                        <h6><b>Account Number:</b> 
                                           {{$listBank->account_number}}
                                        </h6>
                                    </li>
                                  </ul>
                              </div>
                            </div>
                          </div>
                          @endforeach
                        @endif
                    </div>
                  </div>
                </div>
                 @include('PartialView.todoList')
            </div>

        </div>
      </div>
    </div>

@stop

@section('styles')
<!--//-->
@stop

@section('scripts')
 <!--//-->
@stop