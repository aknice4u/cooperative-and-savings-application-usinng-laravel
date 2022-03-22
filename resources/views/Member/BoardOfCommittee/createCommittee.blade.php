@extends('Layouts.layoutSelector')
@section('pageTitle')
   Create New/Update Excutive Committee
@stop
@section('content')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <div class="main-panel">
        <div class="content-wrapper">
          <div style="width:150%">
            
           <div class="col-md-12 col-xs-12 col-ms-12 grid-margin grid-margin-md-0 stretch-card">
              <div class="card">
                <div class="card-body">
                  <div align="center"><h4 class="card-title profile-page"><b>@yield('pageTitle')</b></h4></div>
                  <!--Your contents go thus...-->

                 	<div class="row">
                 	   <div class="col-md-6 offset-md-2">
                 	   	 <!-- Default form login -->
				<form class="text-center border border-light p-5" method="post" action="{{ route('createCommittee') }}">
				{{ csrf_field() }}
				
				<!--//error-->
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
			                        <strong>Completed!</strong> <br />
			                        {{ session('message') }}
			                    </div>                        
			                @endif
			
			                @if(session('error'))
			                    <div class="alert alert-warning alert-dismissible" role="alert">
			                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
			                        </button>
			                        <strong>Error!</strong> <br />
			                        {{ session('error') }}
			                    </div>                        
			                @endif
			            </div>
			            <!--//error-->
			            

				    <label class="pull-left">Executive&apos;s Name:</label>
				    <input type="text" id="name" value="{{ old('executiveName') }}" name="executiveName" class="form-control mb-4" required placeholder="Executive Name">
				
				    <label class="pull-left">Position:</label>
				    <input type="text" id="position" value="{{ old('executivePosition') }}" name="executivePosition" class="form-control mb-4" required  placeholder="Executive Position">
				    
				    <label class="pull-left">Location:</label>
				    <input type="text" id="location" name="location" value="{{ old('location') }}" class="form-control mb-4" required  placeholder="Location (Optional)">
				    
				     <label class="pull-left">Telephone Number:</label>
				    <input type="text" id="telephone" value="{{ old('telephoneNumber') }}" name="telephoneNumber" class="form-control mb-4" placeholder="Telephone Number">
				    
				     <label class="pull-left">Email (Optional):</label>
				    <input type="text" id="telephone" name="email" value="{{ old('email') }}" class="form-control mb-4" placeholder="Email Address (Optional)">
				    
				    <!-- Sign in button -->
				    <button class="btn btn-success btn-block my-4" type="submit">Create New</button>
				</form>
				<!-- Default form login -->
                 	   </div>
                 	   
	                 <div class="col-md-12" align="center"> <hr />
			     <table class="table table-stripped table-hover table-condensed table-responsive">
			     	   <thead>
					<tr>
					    <th>S/N</th>
					    <th>NAME OF EXECUTIVE</th>
					    <th>POSITION</th>
					    <th>LOCATION</th>
					    <th>TELEPHONE NUMBER</th>
					    <th>EMAIL</th>
					    <th colspan="2"></th>
					</tr>
				   </thead>
				   <tbody>
					@forelse($getAllExecutive as $key => $listMgt)
					    <tr>
					    	<td> {{ 1 + $key++ }} </td>
					    	<td> {{ $listMgt->executive_name }} </td>
					    	<td> {{ $listMgt->position }} </td>
					    	<td> {{ $listMgt->location}} </td>
					    	<td> {{ $listMgt->telephone }} </td>
					    	<td> {{ ($listMgt->email) ? $listMgt->email : ' - ' }} </td>
					    	<td> <a href="javascript:;"  data-toggle="modal" data-target="#editDetails{{$listMgt->executiveID}}"><i class="icon icon-pencil text-info"></i></a> </td>
					    	<td> <a href="javascript:;"  data-toggle="modal" data-target="#deleteDetails{{$listMgt->executiveID}}"><i class="icon icon-trash text-danger"></i></a> </td>
					    </tr>
					    
					  <!---Edit modal--->
					  <form class="text-center border border-light p-5" method="post" action="{{ route('updateCreateCommittee') }}">
					  {{ csrf_field() }}
		                          <div class="modal fade" id="editDetails{{$listMgt->executiveID}}" tabindex="-1" role="dialog" aria-labelledby="editDetails{{$listMgt->executiveID}}">
		                            <div class="modal-dialog" role="document">
		                              <div class="modal-content">
		                              <div class="modal-body">
		                                <div>
		                                    <div align="center">
		                                      <h4>Edit Details</h4>
		                                    </div>
		                                    <br />
		                                  <div align="left">
		                                       	    <label class="pull-left">Executive&apos;s Name:</label>
							    <input type="text" id="name" name="executiveName" value="{{ $listMgt->executive_name }}" class="form-control mb-4" required placeholder="Executive Name">
							
							    <label class="pull-left">Position:</label>
							    <input type="text" id="position" name="executivePosition" value="{{ $listMgt->position }}" class="form-control mb-4" required  placeholder="Executive Position">
							    
							    <label class="pull-left">Location:</label>
							    <input type="text" id="location" name="location" value="{{ $listMgt->location}}" class="form-control mb-4" required  placeholder="Location (Optional)">
							    
							     <label class="pull-left">Telephone Number:</label>
							    <input type="text" id="telephone" name="telephoneNumber" value="{{ $listMgt->telephone }}" class="form-control mb-4" placeholder="Telephone Number">
							    
							     <label class="pull-left">Email (Optional):</label> 
							    <input type="text" id="telephone" name="email" value="{{ $listMgt->email}}" class="form-control mb-4" placeholder="Email Address (Optional)">
							    <input type="hidden" name="recordDetails" value="{{ $listMgt->executiveID}}">
		                                  </div>
		                                </div>
		                                </div>
		                                <div class="modal-footer"> <!--btn-flat-->
		                                 <button type="submit" class="btn btn-success btn-sm">Save and Continue</button>
		                                  <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">No, Cancel</button>
		                                </div>
		                              </div>
		                            </div>
		                          </div>
		                          </form>
		                          <!--end modal-->
		                          
		                           <!---delete modal--->
		                          <div class="modal fade" id="deleteDetails{{$listMgt->executiveID}}" tabindex="-1" role="dialog" aria-labelledby="deleteDetails{{$listMgt->executiveID}}">
		                            <div class="modal-dialog" role="document">
		                              <div class="modal-content">
		                              <div class="modal-body">
		                                <div align="center">
		                                    <img src="{{asset('assets/images/delete.png')}}">
		                                    <br />
		                                  <big>
		                                      <b>Are you sure you want to delete this record?</b><br />
		                                      You will not be able to recover this record again!
		                                  </big>
		                                </div>
		                                </div>
		                                <div class="modal-footer"> <!--btn-flat-->
		                                  <a href="{{url('delete-committee/' . $listMgt->executiveID)}}" class="btn btn-warning btn-sm">Yes, Delete</a>
		                                  <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">No, Cancel</button>
		                                </div>
		                              </div>
		                            </div>
		                          </div>
		                          <!--end modal-->
                          	
					@empty
					    <tr><td colspan="5" class="text-danger text-center">No record found !</td><tr>
					@endforelse
				   </tbody>
			      </table>
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