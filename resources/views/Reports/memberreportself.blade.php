@extends('Layouts.layoutSelector')
@section('pageTitle')
   My Transaction History
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

                       <section class="flat-row v6">

            <div class="container">

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
                    <div class="col-md-12">  

                        <div align="left" class="title-section style3 left">

                            
                            <form class="form-horizontal" method="post" id ="thisform">
                            {{ csrf_field() }}  
                            <div class="row">
                            	 
				    <div class="col-md-2">
				    	<label >From:</label>
				      	<input type="text" name="from" id="datepickerX" class="form-control" value="{{$from}}" required readonly/> 
				    </div>
				    <div class="col-md-2">
				    	<label >To:</label>
				      	<input type="text" name="to" id="datepickerY" class="form-control" value="{{$to}}" required readonly/> 
				    </div>
				    
				    <div class="col-md-3">
				    	<br>
				      	<button type="submit" class="btn btn-success">Go</button>
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
			                <th >Year</th>	
			                <th >Month</th>	             
			                <!--<th >Description</th>
			                <th >Prev Savings. Bal</th>-->
			                <th >Savings</th>
			                <th >Savings Balance</th>
			                <!--<th >Loan Borrowed</th>
			                <th >Loan Prev Bal</th>-->
			                <th >Loan Repay </th>
			                <th >Loan Balance</th>
			                
			                <!--<th >Int Generated</th>
			                <th >Int Prev Bal</th>-->
			                <th >Interest Repay</th>
			                <th >Interest Balance</th>
			                
		          
				
			 	</tr>
			</thead>
						@php $serialNum = 1; @endphp
						
						@foreach ($MemberTransactionReport as $b) 
		
						
						<tr>
							<td>{{ $serialNum ++}} </td>
							<td>{{$b->transaction_date}}</td>
							<td>{{$b->year}}</td>
							<td>{{$b->month}}</td>
							<!--<td>{{$b->description}}</td>
							<td>{{number_format($b->cbal-$b->monthcontribution,2)}}</td>-->
							<td>{{number_format($b->monthcontribution,2)}}</td>
							<td>{{number_format($b->cbal,2)}}</td>
							
							<!--<td>{{number_format($b->loanborrow,2)}}</td>
							<td>{{number_format($b->lbal-$b->loanborrow+$b->loanrepay,2)}}</td>-->
							<td>{{number_format($b->loanrepay,2)}}</td>
							<td>{{number_format($b->lbal,2)}}</td>
							
							<!--<td>{{number_format($b->loaninterest,2)}}</td>
							<td>{{number_format($b->ibal-$b->loaninterest+$b->interestrepay,2)}}</td>-->
							<td>{{number_format($b->interestrepay,2)}}</td>						
							<td>{{number_format($b->ibal,2)}}</td>
							
							
						</tr>
						
						@endforeach	
						
			 </table>
			 
		</div>
		<br><button type="submit" class="btn btn-success">Print</button>
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
function  ReloadForm()
{
	
	document.getElementById('thisform').submit();
	return;
}
</script>
@stop
