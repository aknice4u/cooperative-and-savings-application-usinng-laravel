@extends('Layouts.layoutSelector')
@section('pageTitle')
Applicants Information
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
                @if (session('message'))
	    <div class="alert alert-success">
	        {{ session('message') }}
	    </div>
	@elseif (session('errorMessage'))
	    <div class="alert alert-danger">
	        {{ session('errorMessage') }}
	    </div>
	    @elseif (session('warningMessage'))
	    <div class="alert alert-warning">
	        {{ session('warningMessage') }}
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
                  <h4 align="center" class="card-title profile-page"><b>@yield('pageTitle')</b></h4>
                  
                 
                  <!--Your contents go thus...-->
                    <form method="post" action="{{route('approveApplication')}}" id="form1" enctype="multipart/form-data" style="display:block">
			{{ csrf_field() }}
                 
		 <div id="appl" style="display:visible">
		<div class="col-md-12 ">
		  	<h5><b id="zzname"></b></h5>
		  </div>
		 
		 <div class="form-group">
				    <div align="center" class="col-12">	
            		
            		       @php $imgfile= '/passport/'; @endphp   
		            	 
		            	  @if($applicants->image_ext==null)
			    		 <div id="imagewrapper" style="width: 300px;height:300px;">
			    		 <img src="{{ asset('profilePic/noImage/no_image_available.jpeg') }}" id="output_image" alt="Avatar" style="max-width: 100%;max-height: 100%;" class="image">
			    		 </div>
			    		 @else
			    		 <div id="imagewrapper" style="width: 300px;height:300px;">
			    		 <img src="{{ $imgfile.$applicants->image_ext }}" id="output_image" alt="Avatar" style="max-width: 100%;max-height: 100%;" class="image">
			    		 </div>
			    		 @endif
			    		 
			    		 
			    		
					
				 </div>
				</div>
				<div class="col-12">
				<div class="row">
				<div class="col-md-4 col-sm-12">
                            	  <div class="form-group">
				    
				    
				    <label for="cardNo">ID Card No:</label>
				    
				      <input type="text" class="form-control" name="cardNo" id="cardNo" value="{{ $applicants->cardNo }}" readonly/>
				    
				    
				  </div>
				  </div>
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label  for="gender">gender</label>
				    
				    <input type="text" class="form-control" name="gender" id="gender" value="{{ $applicants->gender }}" readonly/>
				    
				  </div>
				  </div>
				  <div class="col-md-4 col-sm-12">
				   <div class="form-group">
				    <label for="title">Title</label>
				   
				  <input type="text" class="form-control" name="title" id="title" value="{{ $applicants->title }}" readonly/>
				    
				   
				  </div>
				  </div>
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label for="first_name">First Name:</label>
				    
				    
				    <input type="text" class="form-control" name="first_name" id="first_name" value="{{ $applicants->first_name }}" readonly/>
				   
				    
				  </div>
				  </div>
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label  for="middle_name">Middle Name:</label>
				    
				    
				    <input type="text" class="form-control" name="middle_name" id="middle_name" value="{{ $applicants->middle_name }}" readonly/>
				    
				    
				  </div>
				  </div>
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label for="last_name">Last Name:</label>
				    
				   
				      <input type="text" class="form-control" name="last_name" id="last_name" value="{{ $applicants->last_name }}" readonly/>
				   
				    
				  </div> 
				  </div>
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label for="phoneNo">Phone Number:</label>
				    
				    
				      <input type="text" class="form-control" name="phoneNo" id="phoneNo"  value="{{ $applicants->phoneno }}" readonly/>
				    
				    
				  </div>
				  </div>
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label for="email">Email:</label>

				    <input type="email" class="form-control" name="email" id="email"  value="{{ $applicants->email_address }}" readonly/>

				  </div>
				  </div>
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label for="states">State</label>
				    
				    
				      	<input type="text" class="form-control" name="state" id="state"  value="{{ $applicants->State }}" readonly/>
				    
				    
				  </div>
				  </div>
				  <div class="col-md-4 col-sm-12">
				<div class="form-group">
				  	<label  for="lga">L.G.A</label>

					<input type="text" class="form-control" name="lga" id="lga"  value="{{ $applicants->lga }}" readonly/>				   

				</div>
				</div>
				
				<div class="col-md-4 col-sm-12">
				<div class="form-group">
			              <label for="marital_status">Marital Status</label>
						 	
			              	<input type="text" name="marital_status" id="marital_status" class="form-control" value="{{ $applicants->status }}" readonly/>
							
			            </div>
			            </div>
				<div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label for="address">Address:</label>

				      <textarea type="text" class="form-control" id="address" name="address" minlength="10" readonly>{{ $applicants->address }}</textarea>

				  </div>
				  </div>
				<div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label  for="nok">Next of Kin:</label>
				    
				    
				      <input type="text" class="form-control" name="nok" id="nok" value="{{ $applicants->nextofkin }}" readonly/>
				    
				    
				  </div>
				  </div>
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label  for="nok">Relationship With Next of Kin:</label>
				    
				   
				      <input type="text" class="form-control" name="rnok" id="rnok" value="{{ $applicants->relationship_with_nextofkin }}" readonly/>
				    
				    
				  </div>
				  </div>
				  
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label  for="address">Next of Kin&apos;s Address:</label>
				    
				      
				      <textarea type="text" class="form-control" id="nokaddress" name="nokaddress" readonly>{{ $applicants->nextofkin_address }}</textarea>
				    
				    
				  </div>
				  </div>
				  
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label  for="phoneNo">Next of Kin&apos;s Phone Number:</label>
				    
				    
				      <input type="text" class="form-control" name="nokphoneNo" id="nokphoneNo" value="{{ $applicants->nextofkin_phoneno }}" readonly/>

				  </div>
				  </div>
				  
				  <div class="col-md-4 col-sm-12">
				  <!--Add Division here-->
				  <div class="form-group">
				    <label for="monthbution">Monthly Savings:</label>

				      <input type="number" class="form-control" name="monthbution" id="monthbution" value="{{ $applicants->monthly_contribution }}" readonly/>

				  </div>
				  </div>
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label for="division">Branch/Division</label>
				    
				     <input type="text" class="form-control" name="division" id="division" value="{{ $applicants->division }}" readonly/>

				  </div>
				  </div>
				  
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label  for="address">Bank</label>
				    
				    	<input type="text" class="form-control" name="bank" id="bank" value="{{ $applicants->bank }}" readonly/>
				 	
				  </div>
				  </div>
				  
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label for="accNo">Account Number:</label>
				    
				    
				      <input type="number" class="form-control" name="accNo" id="accNo" value="{{ $applicants->account_no }}" readonly/>
				    
				    
				  </div>
				  </div>
				  
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label  for="datepickerX">Date of Employment:</label>
				   
				    
				      <input type="text" name="datepickerX" id="datepickerX" class="form-control input-lg" value="{{ $applicants->employment_date }}" required readonly/> 
				    
				    </div>
				    
				  </div>
				  </div>
				  
				  <div class="form-group"> 
				  <div class="row">
				    <div class="col-sm-3">
				      
				    </div>
				    <div class="col-sm-offset-3 col-sm-3">
				      <button type="submit" name="approve" class="btn btn-success" value="approve">Approve</button>
				    </div>
				    <div class="col-sm-6">
				      <button type="submit" name="approve" class="btn btn-danger" value="deny">Deny</button>
				    </div>
				  </div>
				  </div>
				  </div>
		        </form>
                  <!--//-->
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- //loading modal -->
<div class="modal fade" id="load-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
		<div class="modal-content">
			
                <div class="modal-body">
                    <center>
                        <i class="fa fa-spinner fa-spin" style="font-size:50px"></i><br>
                        Just a moment...
                    </center>
                </div>
                
		</div>
    </div>
    
      </div>
    </div>
</div>
<!-- content-wrapper ends -->
@stop

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/font-awesome/css/font-awesome.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css">
<style type="text/css">
#hm {
margin-top: 10px;
}

#ex {
margin: 10px;
}
</style>

@stop

@section('scripts')
 <script src="{{asset('assets/js/validate.js')}}"></script>
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script>
 
 $(document).ready(function() {
    $('#').DataTable();
  } );

  $(document).ready(function() {
      $('#mytable').DataTable( {
          dom: 'Bfrtip',
          "pageLength": 10,
          buttons: [
              {
                  extend: 'print',
                  customize: function ( win ) {
                      $(win.document.body)
                          .css( 'font-size', '10pt' )
                          .prepend(
                              ''
                          );
   
                      $(win.document.body).find( 'table' )
                          .addClass( 'compact' )
                          .css( 'font-size', 'inherit' );
                  }
              }
          ]
      } );
  } );


</script>
<script type='text/javascript'>	
$.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
      }
    });
function loader(a){
    if(a == 1){
        $('#load-modal').modal({
            backdrop: 'static',
            keyboard: true, 
            show: true
        }); 
    }

    if(a == 2){
        $( '#load-modal' ).modal('hide');
       $('.modal-backdrop').remove()
    }
}
	
function getStaffInfoViaAjax()
{

	staffid = document.getElementById('applicant');
	console.log(staffid.value)
	loader(1);
	
	$.post('/ajaxcall/application', { 'id' : staffid.value}, function (res){
		if(res){
			
			console.log(res)
			res = JSON.parse(res)
			
			loader(2)
			if(res.title == 404){
				alert('No record to retrieve!');
			} else{
			
				//document.getElementById('appl').style.display = "block";
				$('#cardNo').val(res.cardNo)
				$('#title').val(res.title)
				$('#first_name').val(res.first_name)
				$('#middle_name').val(res.middle_name)
				$('#last_name').val(res.last_name)
				$('#gender').val(res.gender)
				$('#state').val(res.State)
				$('#lga').val(res.lga)
				$('#address').val(res.address)
				$('#phoneNo').val(res.phoneno)
				$('#email').val(res.email_address)
				$('#marital_status').val(res.status)
				$('#nok').val(res.nextofkin)
				$('#rnok').val(res.relationship_with_nextofkin)
				$('#nokaddress').val(res.nextofkin_address)
				$('#nokphoneNo').val(res.nextofkin_phoneno)
				$('#monthbution').val(res.monthly_contribution)
				$('#division').val(res.division)
				$('#bank').val(res.bank)
				$('#accNo').val(res.account_no)
				$('#datepickerX').val(res.employment_date)
				
				if(res.image_ext == null)
				{
				
				}else{
				document.getElementById('output_image').src = "{{ asset('/tempPic/')}}/" + res.email_address+ '.'+res.image_ext;
				}
				//for rejection
				$('#incase-na').val(res.lastName+' '+res.firstName+' '+res.middleName)
				$('#incase-em').val(res.email)
				
			}		
		}
	});
	
	//loader(2)
	return false;
}

</script>
@stop