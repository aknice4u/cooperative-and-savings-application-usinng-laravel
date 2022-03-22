@extends('Layouts.layoutSelector')
@section('pageTitle')
   {{ $pagetitle }}
@stop
@section('welcomePageActive')
  active
@stop
@section('styles')
<!--//-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@stop
@section('content')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <div class="main-panel">
        <div class="content-wrapper">
          
          
       
          <div class="row">
            
                
                <div class="col-12 grid-margin stretch-card">
                  <div class="card">
                  
		               <div class="card-body">
				 <div class="row">
		          	<h2>{{ $pagetitle }}</h2>
		          	</div>
		          	<br><br><br>
		                    @if (session()->has('message'))
					    <div class="alert alert-success">
					        {{ session()->get('message') }}
					    </div>
					@elseif (session()->has('error'))
					    <div class="alert alert-danger">
					        {{ session()->get('error') }}
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
					@if($success !== "")
					   <div class="alert alert-success">
					        {{ $success }}
					    </div>
					@endif
					@if($error !== "")
					   <div class="alert alert-danger">
					        {{ $error }}!
					    </div>
					@endif
		                      	<form action="" method="post" id="the-form">
                      		{{ csrf_field() }}
                      		
                      		
                      		<div class="row" style="display:none">
                      		
					<input type="hidden" id="regno" name="regno">
                      			
					
					<div class="col-6">
	                      		 <div class="form-group">
					      <label for="contribution">Bank Name</label>
					      <input type="text" class="form-control" id="bankname" name="bankname" required aria-describedby="emailHelp" placeholder="Enter Bank name">
					      
					    </div>
					</div>
					
					
				</div>
				<div class="row" style="display:none">
				<div class="col-6">
					<button class="btn btn-primary" type="submit">Add Bank</button>
				</div>
				</div>
				<br><br><Br>
				<div class="row">
				<div class="col-12">
					<table class="table table-stiped">
						<thead>
							<th>SN</th>
							<th>Description</th>
							<th>Rate</th>
							<th>Action</th>
						</thead>
						@php $sn = 1; @endphp
						<tbody>
							@foreach($new as $list)
								<tr>
									<td>{{ $sn++ }}</td>
									<td>{{ $list->description }}</td>
									<td>{{ $list->rate }}</td>
									<td><!--<button class="btn btn-sm btn-danger" onclick="return deleteBank({{ $list->ID }}, '{{ $list->description }}')">Delete</button> &nbsp--> &nbsp <button onclick="return callUpdate('{{ $list->description }}', {{ $list->rate }}, {{ $list->ID }})" class="btn btn-sm btn-info"> Update </button> </td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				</div>
                      	</form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
           </form>
          </div>
        </div>
        
        <div class="modal fade" id="z-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">
					Edit Interest Rate
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        &times;
                    </span>
				</button>
			</div>
            <form action="" method="post">
                <div class="modal-body">
                    {{ csrf_field() }}
                        <div class="form-group">
                            <label for="description" class="form-control-label">
                                Description:
                            </label>
                            <input type="text" name="description" id="description" class="form-control m-input" required id="exampleSelect1">											
                            <input type="hidden" name="z-id" id="z-id">
                        </div>
                        
                        <div class="form-group">
                            <label for="rate" class="form-control-label">
                                Rate:
                            </label>
                            <input type="number" min="0" name="rate" id="rate" class="form-control m-input" required id="exampleSelect1">
                        </div>
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                       Update
                    </button>
                </div>
            </form>
		</div>
    </div>
</div>

<!-- content-wrapper ends -->
@stop



@section('scripts')
  <!--//-->
  <Script>
  	$('#date').datepicker({
	    dateFormat: 'yy-mm-dd'
	});
	
	function calc(){
		c = document.getElementById('contribution').value;
		l = document.getElementById('loan').value;
		i = document.getElementById('interest').value;
		tot = Number(c) + Number(l) + Number(i);
		document.getElementById('total').value = tot;
	}
	
	function getMembers(a)
	{
		document.getElementById('the-form').submit();
	}
	
	function placeID()
	{
		if(document.getElementById('reg').value !== ""){
			document.getElementById('regno').value = document.getElementById('reg').value;
		}
	}
	
	function deleteBank(id, name){
		if(confirm('Are you sure you want to delete '+name)){
			window.location.assign('/bank-delete/'+id);
		}
	}
	
	function callUpdate(name, rate, id){
		document.getElementById('description').value = name;
		document.getElementById('rate').value = rate;
		document.getElementById('z-id').value = id;
		$('#z-modal').modal('show');
		return false;
	}
  </script>
@stop