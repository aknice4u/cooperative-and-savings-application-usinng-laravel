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
          	<h2>Payment Transaction </h2>
          </div>
       
          <div class="row">
            
                
                <div class="col-12 grid-margin stretch-card">
                  <div class="card">
                  
		                    <div class="card-body">
		                    
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
                      		
                      		
                      		<div class="row">
                      		<div class="col-6">
	                      		 <div class="form-group">
					      <label for="division">Division</label>
					      <select class="form-control" id="division"  onchange="return getMembers(this)" name="division" aria-describedby="emailHelp" required placeholder="">
						<option value="">select division</option>
						@foreach($division as $list)
							<option value="{{ $list->ID }}" {{ ($division_id == $list->ID) ? "selected" : "" }}>{{ $list->division }}</option>
						@endforeach
					      </select>
					    </div>
					</div>
					<input type="hidden" id="regno" name="regno">
                      			<div class="col-6">
	                      		 <div class="form-group">
					      <label for="reg">Registration Number</label>
					      <input type="text" class="form-control" onchange="return placeID()" list="reg2" id="reg" value="{{ $oldsel }}"  required name="reg" aria-describedby="emailHelp" placeholder="Type registration no or name">
					      <datalist id="reg2">
					      @if($members != null)
					      @foreach($members as $list)
					      	<option value="{{ $list->regNo }} - {{ $list->last_name }} - {{ $list->first_name }} - {{ $list->middle_name }}" >  {{ $list->last_name }} - {{ $list->first_name }} - {{ $list->middle_name }}</option>					      
					      @endforeach
					      @endif
					      </datalist>
					    </div>
					</div>
					

					
	                      		<div class="col-3">
	                      		 <div class="form-group">
					      <label for="date2">Date</label>
					      <input type="text" class="form-control" readonly="readonly" id="date2" name="date"  value="{{ $date }}" required aria-describedby="emailHelp" placeholder="Date">
					      
					    </div>
					</div>
					
					<div class="col-3">
	                      		 <div class="form-group">
					      <label for="contribution">Savings</label>
					      <input type="number" class="form-control" id="contribution" min="0" value="{{ $saving }}" onkeyup="return calc()" onkeypress="return calc()" name="contribution" aria-describedby="emailHelp" placeholder="Savings">
					      
					    </div>
					</div>
					
					<div class="col-3">
	                      		 <div class="form-group">
					      <label for="loan">Loan</label>
					      <input type="number" class="form-control" id="loan" min="0" value="{{ $loan}}" onkeyup="return calc()" onkeypress="return calc()" name="loan" aria-describedby="emailHelp" placeholder="Loan">
					      
					    </div>
					</div>
					
					<div class="col-3">
	                      		 <div class="form-group">
					      <label for="interest">Interest</label>
					      <input type="number" class="form-control" min="0" value="{{ $interest }}" onkeyup="return calc()" onkeypress="return calc()" id="interest" name="interest" aria-describedby="emailHelp" placeholder="Interest">				      
					    </div>
					</div>
					
					<div class="col-6">
	                      		 <div class="form-group">
					      <label for="loan">Description</label>
					      <textarea class="form-control" id="description"  required name="description" aria-describedby="emailHelp">{{ $description }}</textarea>			      
					    </div>
					</div>
					<div class="col-3">
	                      		 
					</div>
					<div class="col-3">
	                      		 <div class="form-group">
					      <label for="loan">Total</label>
					      <input type="text" class="form-control" id="total" name="total" aria-describedby="emailHelp" readonly="readonly">			      
					    </div>
					</div>
				</div>
				<div class="row">
					<button class="btn btn-primary" type="submit">Save</button>
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
<!-- content-wrapper ends -->
@stop



@section('scripts')
  <!--//-->
  <script>
  	
	  	$('#date2').datepicker({
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
	
	
  </script>
@stop