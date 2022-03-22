@extends('Layouts.layoutSelector')
@section('pageTitle')
   REGISTERED MEMBERS
@stop
@section('content')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            @if ($warning<>'')
					<div class="alert alert-dismissible alert-danger">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>{{$warning}}</strong> 
					</div>
					@endif
					@if ($success<>'')
					<div class="alert alert-dismissible alert-success">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>{{$success}}</strong> 
					</div>
					@endif
           <div class="col-md-12 col-xs-12 col-ms-12 grid-margin grid-margin-md-0 stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title nav-link text-center"><b>@yield('pageTitle')</b></h4>
                  <!--Your contents go thus...-->

                      <section class="flat-row v6">

            <div class="container">

                <div class="row">

                    <div class="col-md-12">  

                        <div align="left" class="title-section style3 left">

                            
                            <form class="form-horizontal" method="post" id ="thisform">
                            {{ csrf_field() }}  
                            	  <div class="form-group">
				    
				    
				   
				    <div class="col-sm-3">
				    	<label >Division:</label>
				      	<select type="text" id="division" name="division" class="formex form-control"  onchange="ReloadForm()">
					<option value="">All Division</option>
					
					@foreach ($divisions as $b)
					<option value="{{$b->ID}}" @if(old('division') == $b->ID||$division == $b->ID) selected @endif>{{$b->division}}</option>
		                	@endforeach 
				 	</select>
				    </div>
				    <div class="col-sm-3">
				    	<br>
				      	<button type="submit" class="btn btn-success" name="go">Go</button>
				    </div>
				  </div>
				  <div class="form-group"> 
				    <div class="col-sm-offset-0 col-sm-12">
				      
				    </div>
				  </div>
				</form>
				  <div class="table-responsive" style=" padding:10px;">
			<table class="table table-bordered table-striped table-highlight" id="zable">
			<thead>
				<tr bgcolor="#c7c7c7">
			                <th >S/N</th>
			                <th>Image</th> 
			               	<th >Membership No</th>
			                <th >Name</th>	
			                <th >Phone Number</th>
			                <th> Division </th>
			                
			 	</tr>
			</thead>
			<tbody>
			@php
				$sn = 1;
			@endphp
				@if($members)
					@foreach($members as $list)
					@php
						$pic = 'profilePic/noImage/no_image_available.jpeg';
						if($list->image_ext !== null && $list->email_address !== ""){
							$pic = 'profilePic/'.$list->email_address.'.'.$list->image_ext;
						}
					@endphp
						<tr>
							<td>{{ $sn++ }}</td>
							<td> <img src="{{ asset($pic) }}" class="img-circle img-responsive"> </td>
							<td>{{ $list->regNo }}</td>
							<td>{{ $list->last_name }} {{ $list->first_name }} {{ $list->middle_name }}</td>
							<td>{{ $list->phoneno }}</td>
							<td> {{  $list->division }} </td>					
							
						</tr>
					@endforeach
				@else
					<tr>
						<td>
							<center>There are no available records</center>
						</td>
					</tr>
				@endif
			</tbody>		
			 </table>
			 
		</div>
		<div class="row">
				    
				    
				    
				    <div class="col-sm-10">
				    	<br>
				    	
				      	 <!---<button type="button" class="btn btn-success" >Print</button>-->
				    </div>
				    
				    
				  </div>
		
			  
                            

                        </div>       
                    </div>

                </div>
            </div>  

        </section>

                  <!--//-->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
<!-- content-wrapper ends -->

<div class="modal fade" id="z-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">
					More details <span id="the-named" class="text-primary"></span>
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        &times;
                    </span>
				</button>
			</div>
            <table class="table table-striped table-responsive">
            	
            	<tbody id="table-space">
            		
            	</tbody>
            </table>
		</div>
    </div>
</div>
@stop

@section('styles')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('scripts')
<script src="{{asset('assets/js/validate.js')}}"></script>
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script type='text/javascript'>
$('#datepickerX').datepicker({
    dateFormat: 'yy-mm-dd'
});
$('#datepickerY').datepicker({
    dateFormat: 'yy-mm-dd'
});


function  Modify(code)
	{
	
	var x=document.getElementById(code+"contribution").value;
	document.getElementById("member").value=document.getElementById(code+"names").value;
	document.getElementById("loanrepayment").value=document.getElementById(code+"loan").value;
	document.getElementById("intrepayment").value=document.getElementById(code+"interest").value;
	document.getElementById("contribution").value=document.getElementById(code+"contribution").value;
	document.getElementById("regno").value=code;
	$('#showmodication').modal('show')
	  return;
}
function  ReloadForm()
{
	
	document.getElementById('thisform').submit();
	return;
}


$(document).ready(function() {
    $('#zable').DataTable();
} );
</script>
@stop
