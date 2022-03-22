@extends('Layouts.layoutSelector')
@section('pageTitle')
  Member Transaction History Archive
@stop
@section('content')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
          
			         @if (session('message'))
				    <div class="alert alert-success">
				        {{ session('message') }}
				    </div>
				@elseif (session('errorMessage'))
				    <div class="alert alert-danger">
				        {{ session('errorMessage') }}
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

                        <div >

                           
                            <form class="form-horizontal" method="post" id ="thisform">
                            {{ csrf_field() }}  
                            
                            	  <div class="row">
				    
				    <div class="col-md-5">
				    	<label >Member Details:</label>
				      	<input type="hidden"  id="regno" name="regno"  value="{{$regno}}">
				    	<input type="text" list="refregno"  id="refregno1"  name="refregno" class="form-control" value="{{$refregno}}" autocomplete="off"  placeholder="Select member" onchange="fetchMain()">
                        <datalist id="refregno">
                            @foreach($MemberList as $list)
                            <option value="{{ $list->regNo }}:{{ $list->Names }}">{{ $list->regNo }}:{{ $list->Names }}</option>
                            @endforeach
            			</datalist>
				    </div>
				    <div class="col-md-2">
				    	<label >From:</label>
				      	<input type="text" name="from" id="datepickerX" class="form-control input-lg" value="{{$from}}" required readonly/> 
				    </div>
				    <div class="col-md-2">
				    	<label >To:</label>
				      	<input type="text" name="to" id="datepickerY" class="form-control input-lg" value="{{$to}}" required readonly/> 
				    </div>
				    
				    <div class="col-md-3">
				    	<br>
				      	<button type="submit" class="btn btn-success" >Go</button>
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
			               	<th >Transaction Date</th>
			                <th >Year perio</th>	
			                <th >Month Period</th>	             
			                <th >Description</th>
			                <th >Prev Savings Bal</th>
			                <th >Savings</th>
			                <th >Savings Bal</th>
			                <th >Loan Borrowed</th>
			                <th >Loan Prev Bal</th>
			                <th >Loan Repay </th>
			                <th >Loan Bal</th>
			                <th >Int Generated</th>
			                <th >Int Prev Bal</th>
			                <th >Int repay</th>
			                <th >Int Balance</th>
			                <th >Action</th>
			                
		          
				
			 	</tr>
			</thead>
				<tr>
					<td> </td>
					
					<td>
					@php
					if(old('transactionDate')!=''){$transactionDate=old('transactionDate');} 
					 @endphp
					<input type="text" name="transactionDate" id="datepickerZ" class="form-control input-lg" value="{{$transactionDate}}" style="width:150px;" placeholder="YYYY-MM-DD" readonly/> </td>
					<td><select type="text" id="year" name="year" class="formex form-control"  style="width:150px;" >
					<option value="">Year</option>
					@for($i=2010;$i<=2040;$i++)
			                <option value="{{$i}}" @if(old('year') == $i||$year == $i) selected @endif>{{$i}}</option>
			                @endfor
				 	</select></td>				
					<td><select type="text" id="month" name="month" class="form-control" style="width:100px;" >				
						<option value="">Month </option>
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
				 	</select></td>
					<td>
					@php
					if(old('description')!=''){$description=old('description');} 
					 @endphp
					<input type="text" style="width:150px;" name="description" class="form-control"> </td>
					<td></td>
					<td>
					@php
					if(old('monthcontribution')!=''){$monthcontribution=old('monthcontribution');} 
					 @endphp
					 <input type="text" style="width:100px;" name="monthcontribution" class="form-control"></td>
					<td></td>
					<td>
					@php
					if(old('loanborrow')!=''){$loanborrow=old('loanborrow');} 
					 @endphp
					 <input type="text"  style="width:100px;" name="loanborrow" class="form-control"></td>
					<td></td>
					<td>
					@php
					if(old('loanrepay')!=''){$loanrepay=old('loanrepay');} 
					 @endphp
					 <input type="text"  style="width:100px;" name="loanrepay" class="form-control"></td>
					<td></td>
					
					<td>
					@php
					if(old('loaninterest')!=''){$loaninterest=old('loaninterest');} 
					 @endphp<input type="text"  style="width:100px;" name="loaninterest" class="form-control"></td>
					<td></td>
					<td>
					@php
					if(old('interestrepay')!=''){$interestrepay=old('interestrepay');} 
					 @endphp
					 <input type="text" style="width:100px;" name="interestrepay" class="form-control"></td>						
					<td></td>
					<td><button type="submit" class="btn btn-success" name="add">Add</button></td>
					
					
				</tr>
						@php $serialNum = 1; @endphp
						
						@foreach ($MemberTransactionReport as $b) 
		
						
						<tr>
							<td>{{ $serialNum ++}} </td>
							<td>{{$b->transaction_date}}</td>
							<td>{{$b->year}}</td>
							<td>{{$b->month}}</td>
							<td>{{$b->description}}</td>
							<td>{{number_format($b->cbal-$b->monthcontribution,2)}}</td>
							<td>{{number_format($b->monthcontribution,2)}}</td>
							<td>{{number_format($b->cbal,2)}}</td>
							<td>{{number_format($b->loanborrow,2)}}</td>
							<td>{{number_format($b->lbal-$b->loanborrow+$b->loanrepay,2)}}</td>
							<td>{{number_format($b->loanrepay,2)}}</td>
							<td>{{number_format($b->lbal,2)}}</td>
							
							<td>{{number_format($b->loaninterest,2)}}</td>
							<td>{{number_format($b->ibal-$b->loaninterest+$b->interestrepay,2)}}</td>
							<td>{{number_format($b->interestrepay,2)}}</td>						
							<td>{{number_format($b->ibal,2)}}</td>
							<td><button type="submit" class="btn btn-success" name="delete">Delete</button></td>
							
						</tr>
						
						@endforeach	
						
			 </table>
			 
		</div>
		<div class="form-group"> 
				    <div class="col-sm-offset-0 col-sm-12">
				      <button type="submit"  class="btn btn-success">Print</button>
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
$('#datepickerZ').datepicker({
    dateFormat: 'yy-mm-dd'
});
function  ReloadForm()
{
	
	document.getElementById('thisform').submit();
	return;
}
function fetchMain()
    {
        var txv=document.getElementById('refregno1').value;
    	var tx = txv.split(':');
    	var id=tx[0];
        document.getElementById('regno').value= id; 
        document.getElementById('thisform').submit();
	return;
    }
</script>
@stop

