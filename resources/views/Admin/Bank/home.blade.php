@extends('Layouts.layoutSelector')
@section('pageTitle')
   Add Bank Details
@stop
@section('content')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <div class="main-panel">
        <div class="content-wrapper">
        
       
          <div class="row">
              <div class="col-md-12">
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
                       
                @if(session('message'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Success!</strong> 
                        {{ session('message') }}
                    </div>                        
                @endif

                @if(session('error'))
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Error!</strong> 
                        {{ session('error') }}
                    </div>                        
                @endif
            </div>

                <div class="col-md-6 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title"><b>ADD NEW BANK DETAILS</b></h4>

                      <form action="{{route('postBankDetails')}}" method="post">
                        {{ csrf_field() }}
                          <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="accountName">Account Name</label>
                                    <input type="Text" name="accountName" class="form-control" value="{{ old('accountName') }}" required>
                                  </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                      <label for="bankName">Bank Name</label>
                                      <input type="Text" name="bankName" class="form-control" value="{{ old('bankName') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                      <label for="userName">Account Number</label>
                                      <input type="Text" name="accountNumber" class="form-control" value="{{ old('accountNumber') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                   <div>
                                     <input type="submit" name="submit" class="btn btn-success" value="Add Bank">
                                   </div>
                                </div>
                          </div>
                        </form>

                    </div>
                  </div>
                </div>
                
                <div class="col-md-6 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title"><b>ALL BANKS</b></h4>
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
                                  <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#basic_modal{{$listBank->bankID}}">Delete</button>
                              </div>
                            </div>
                          </div>
                          <!---delete modal--->
                          <div class="modal fade" id="basic_modal{{$listBank->bankID}}" tabindex="-1" role="dialog" aria-labelledby="basic_modal{{$listBank->bankID}}">
                            <div class="modal-dialog" role="document">
                              <div class="modal-content">
                              <div class="modal-body">
                                <div align="center">
                                    <img src="{{asset('assets/images/delete.png')}}">
                                    <img src="" itemprop="thumbnail" alt=" " style="width: 100px; height: 50px;">
                                    <br />
                                  <big>
                                      <b>Are you sure you want to delete this record?</b><br />
                                      You will not be able to recover this record again!
                                  </big>
                                </div>
                                </div>
                                <div class="modal-footer"> <!--btn-flat-->
                                  <a href="{{url('remove-bank-details/' . $listBank->bankID)}}" class="btn btn-warning btn-sm">Yes, Delete</a>
                                  <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">No, Cancel</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!--end modal-->
                          @endforeach
                        @endif
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