@extends('Layouts.layoutSelector')
@section('pageTitle')
   Edit Account
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

                            <h4 class="title">Monthly Contribution Approval</h4>
                            <form class="form-horizontal" method="post" id ="thisform">
                            {{ csrf_field() }}  
                            	  <div class="form-group">
				    
				    <div class="col-sm-3">
				    	<label >Year:</label>
				      	<select type="text" id="year" name="year" class="formex form-control" required >
					<option value="">Select year</option>
					@for($i=2010;$i<=2040;$i++)
			                <option value="{{$i}}" @if(old('year') == $i||$year == $i) selected @endif>{{$i}}</option>
			                @endfor
				 	</select>
				    </div>
				    <div class="col-sm-3">
				    	<label>Month:</label>
				      	<select type="text" id="month" name="month" class="formex form-control" required >
					
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
				 	</select>
				    </div>
				    <div class="col-sm-3">
				    	<label >Division:</label>
				      	<select type="text" id="division" name="division" class="formex form-control"  onchange="ReloadForm()">
					<option value="">All Division</option>
					
					@foreach ($Divisions as $b)
					<option value="{{$b->ID}}" @if(old('division') == $b->ID||$division== $b->ID) selected @endif>{{$b->division}}</option>
		                	@endforeach 
				 	</select>
				    </div>
				    <div class="col-sm-3">
				    	<br>
				      	<button type="submit" class="btn btn-success" name="go">Retrieve</button>
				    </div>
				  </div>
				  <div class="form-group"> 
				    <div class="col-sm-offset-0 col-sm-12">
				      
				    </div>
				  </div>
				  <div class="table-responsive" style=" padding:10px;">
			<table class="table table-bordered table-striped table-highlight" id="mytable">
			<thead>
				<tr bgcolor="#c7c7c7">
			                <th width="1%">S/N</th>	 
			               	<th >Membership No</th>
			                <th >Name</th>	
			                <th >Branch</th>	             
			                <th >Monthly Contribution</th>
			                <th >Loan repayment</th>
			                <th >Interst Repayment</th>
			                <th >This Month Total</th>
			                <th >Action</th>
			                
		          
				
			 	</tr>
			</thead>
						@php $serialNum = 1; @endphp
						@php $summonthly_contribution = 0; @endphp
						@php $sumloan_repay = 0; @endphp
						@php $suminterest_repay = 0; @endphp
						@php $sumtotalPayment = 0; @endphp
						@php $grouphead = ""; @endphp
						@foreach ($MonthlyDefault  as $b) 
						@php $summonthly_contribution += $b->monthly_contribution; @endphp
						@php $sumloan_repay += $b->loan_repay; @endphp
						@php $suminterest_repay += $b->interest_repay; @endphp
						@php $sumtotalPayment += $b->totalPayment ; @endphp
						
						<tr>
							<td>{{ $serialNum ++}} </td>
							<td>{{$b->regno}}</td>
							<td>{{$b->Names}}</td>
							<td>{{$b->division}}</td>
							<td>{{number_format($b->monthly_contribution,2)}}</td>
							<td>{{number_format($b->loan_repay,2)}}</td>
							<td>{{number_format($b->interest_repay,2)}}</td>
							<td>{{number_format($b->totalPayment,2) }}</td>
							<td><button type= "button" class="btn btn-success btn-sm" onclick="Modify('{{$b->regno}}')">Modify</button></td>
						</tr>
						<input id ="{{$b->regno}}contribution" type="hidden"  value="{{$b->monthly_contribution}}">
						<input id ="{{$b->regno}}loan" type="hidden"   value="{{$b->loan_repay}}">
						<input id ="{{$b->regno}}interest" type="hidden"   value="{{$b->interest_repay}}">
						<input id ="{{$b->regno}}names" type="hidden"   value="{{$b->Names}}">
						
						@endforeach	
						<tr>
							
							<td colspan=4><b>Total</b></td>
							
							<td><b>{{number_format($summonthly_contribution}}</b></td>
							<td><b>{{number_format($sumloan_repay,2)}}</b></td>
							<td><b>{{number_format($suminterest_repay,2)}}</b></td>
							<td><b>{{number_format($sumtotalPayment ,2)}}</b></td>
							<td></td>
						</tr>	
			 </table>
			 <button type="submit" class="btn btn-success" name="process">Process</button>
		</div>
		<div class="modal fade" id="showmodication" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" >
				Modify Member Monthly Contribution
			</div>
			<div class="modal-header" >
				<input type="text"  id="member"  class="form-control" readonly>
			</div>
			<div class="modal-body col-sm-12" style="padding: 10px;">
				<div class="row">
					<div class="col-md-4">
						<label>Monthly Contribution</label>
						<input type="text"  name="contribution" id="contribution"  class="form-control" placeholder="0">
					</div>
					<div class="col-md-4">
						<label>Loan Capital Repayment</label>
						<input type="text"  name="loanrepayment" id="loanrepayment" class="form-control" placeholder="0">
					</div>	
					<div class="col-md-4">
						<label>Interest Repaymemt</label>
						<input type="text"  name="intrepayment" id="intrepayment" class="form-control" placeholder="0">
						<input id ="regno" type="hidden" name="regno" >
					</div>						
			</div>	
			</div>
			<div class="modal-footer">
				<button type="submit" name="modify" class="btn btn-danger">
					Update
				</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
			  </form>
                            

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
</script>
@stop