@extends('Layouts.layoutSelector')
@section('pageTitle')
List of Applicants
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
                  
                  <!-- display applicants details in a table-->
            <div class="table-responsive" style=" padding:1px; font-size: 10px">
			<table class="table table-bordered table-highlight" id="mytable">
			<thead>
				<tr bgcolor="#c7c7c7" >
			                <th width="1%">S/N</th>	 
			               	<th>Membership No</th>
			               	<th>First Name</th>
			               	<th>Middle Name</th>
			               	<th>Last Name</th>
			               	<th>Phone No</th>
			               	<th></th>
			                
			                
		          
				
			 	</tr>
			</thead>
        			@php $i=1;@endphp
        			@foreach($app as $b)
						   <tr bgcolor="#ff4933">
						
							<td>{{ $i++}} </td>
							<td>{{$b->cardNo}}</td>
							<td>{{$b->first_name}}</td>
							<td>{{$b->middle_name}}</td>
							<td>{{$b->last_name}}</td>
							<td>{{$b->phoneno}}</td>
							<td><a href="{{'retrieve-applicant'.'/'.$b->cardNo }}"><i class="fa fa-edit" style="cursor:pointer"></i></a></td>
						
						</tr>
						@endforeach	
						
					 
				</table>
			 
		        </div>
                  <!--Your contents go thus...-->

			
		 
		
                  <!--//-->
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- //loading modal -->
    </div>

<!--applicant modal-->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        
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