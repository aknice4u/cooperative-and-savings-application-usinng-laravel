@extends('Layouts.layoutSelector')
@section('pageTitle')
   Contribution from Salary
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
                  <h4 class="card-title nav-link text-center"><b>@yield('pageTitle')</b></h4>
                  <!--Your contents go thus...-->
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
                       
            <div class="container">

              
 

                       

                            
                            <form  method="post" id ="thisform">
                            {{ csrf_field() }}  
                            <div class="row">
                            	<div class="col-md-3">
	                            	<label >Year:</label>
					<select type="text" id="year" name="year" class="form-control" required onchange="ReloadForm()" >
					<option value="">Select year</option>
					@for($i=2010;$i<=2040;$i++)
					<option value="{{$i}}" @if(old('year') == $i||$year == $i) selected @endif>{{$i}}</option>
					@endfor
					</select>
				</div>
                            	<div class="col-md-3">
                            	<label>Month:</label>
				<select type="text" id="month" name="month" class="form-control" required onchange="ReloadForm()" >
				<option value="">Select Month </option>
						<option value="JANUARY" @if(old('month') == 'JANUARY'||$month == 'JANUARY') selected @endif>January</option>
						<option value="FEBRUARY" @if(old('month') == 'FEBRUARY'||$month == 'FEBRUARY') selected @endif>February</option>
						<option value="MARCH" @if(old('month') == 'MARCH'||$month == 'MARCH') selected @endif>March</option>
						<option value="APRIL" @if(old('month') == 'APRIL'||$month == 'APRIL') selected @endif>April</option>
						<option value="MAY" @if(old('month') == 'MAY'||$month == 'MAY') selected @endif>May</option>
						<option value="JUNE" @if(old('month') == 'JUNE'||$month == 'JUNE') selected @endif>June</option>
						<option value="JULY" @if(old('month') == 'JULY'||$month == 'JULY') selected @endif>July</option>
						<option value="AUGUST" @if(old('month') == 'AUGUST'||$month == 'AUGUST') selected @endif>August</option>
						<option value="SEPTEMBER" @if(old('month') == 'SEPTEMBER'||$month == 'SEPTEMBER') selected @endif>September</option>
						<option value="OCTOBER" @if(old('month') == 'OCTOBER'||$month == 'OCTOBER') selected @endif>October</option>
						<option value="NOVEMBER" @if(old('month') == 'NOVEMBER'||$month == 'NOVEMBER') selected @endif>November</option>
						<option value="DECEMBER" @if(old('month') == 'DECEMBER'||$month == 'DECEMBER') selected @endif>December</option>
				</select></div>
                            	<div class="col-md-3">
                            	<label >Division:</label>
				<select type="text" id="division" name="division" class="form-control"  onchange="ReloadForm()">
				<option value="">All Division</option>
				
				@foreach ($Divisions as $b)
				<option value="{{$b->ID}}" @if(old('division') == $b->ID||$division== $b->ID) selected @endif>{{$b->division}}</option>
						@endforeach 
				</select></div>
				<div class="col-md-3">
                            	<br>
					<button type="submit" class="btn btn-success" name="go">Reload</button>
				</div>
                            </div>
                            
                            				
				  
				  <div class="table-responsive" style=" padding:10px;">
			<table class="table table-bordered table-striped table-highlight" id="mytable">
			<thead>
				<tr bgcolor="#c7c7c7">
			                <th width="1%">S/N</th>	 
			               	<th >Membership No</th>
			                <th >Name</th>	
			                <th >Division</th>	             	                
			                <th >Contributions from Salary</th>
			               
			                
		          
				
			 	</tr>
			</thead>
						@php $serialNum = 1; @endphp
						@php $contribution = 0; @endphp
						@php $grouphead = ""; @endphp
						@foreach ($ViewSalaryContribution as $b) 
						
						@php $contribution += $b->amount; @endphp
						
						<tr>
							<td>{{ $serialNum ++}} </td>
							<td>{{$b->regno}}</td>
							<td>{{$b->Names}}</td>
							<td>{{$b->division}}</td>
							<td>{{number_format($b->amount,2) }}</td>
							
						</tr>
					
						
						@endforeach	
						<tr>
							
							<td colspan=4><b>Total</b></td>
							<td><b>{{number_format($contribution ,2) }}</b></td>
							
						</tr>	
			 </table>
			 
		</div>
		
		
	</form>
                            

                        
                    

               
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



function  ReloadForm()
{
	
	document.getElementById('thisform').submit();
	return;
}
</script>
@stop

