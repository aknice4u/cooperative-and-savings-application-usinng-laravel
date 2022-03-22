@extends('Layouts.layoutSelector')
@section('pageTitle')
   MEMBERS SUMMARY DETAILS
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
				    
				    <div class="col-sm-2">
				    	<label >Reports as at:</label>
				      	<input type="text" name="to" id="datepickerX" class="form-control input-lg" value="{{$to}}" required readonly/> 
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
				      	<button type="submit" class="btn btn-success" name="go">Go</button>
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
			                <th >Division</th>	             
			                <th >Savings Balance</th>
			                <th >Loan Balance</th>
			                <th >Interst Balance</th>
			                <th >Gross Balance</th>
			                
			                
		          
				
			 	</tr>
			</thead>
						@php $serialNum = 1; @endphp
						@php $sumcontribution = 0; @endphp
						@php $sumloan = 0; @endphp
						@php $suminterest = 0; @endphp
						@php $sumtotalPayment = 0; @endphp
						@php $sumgross = 0; @endphp
						@foreach ($MemberSummaryLists  as $b) 
						@php $sumcontribution += $b->CB; @endphp
						@php $sumloan+= $b->LCB; @endphp
						@php $suminterest += $b->LIB; @endphp
						@php $sumgross += $b->CB-($b->LIB+$b->LCB); @endphp
						
						<tr>
							<td>{{ $serialNum ++}} </td>
							<td>{{$b->regNo}}</td>
							<td>{{$b->Names}}</d>
							<td>{{$b->Division}}</td>
							<td>{{number_format($b->CB,2)}}</td>
							<td>{{number_format($b->LCB,2)}}</td>
							<td>{{number_format($b->LIB,2)}}</td>
							<td>{{number_format($b->CB-($b->LIB+$b->LCB),2)}}</td>
						</tr>
						
						
						@endforeach	
						<tr>
							
							<td colspan=4><b>Total</b></td>
							
							<td><b>{{number_format($sumcontribution,2) }}</b></td>
							<td><b>{{number_format($sumloan,2) }}</b></td>
							<td><b>{{number_format($suminterest,2) }}</b></td>
							<td><b>{{number_format($sumgross ,2) }}</b></td>
							
						</tr>	
			 </table>
			 
		</div>
		<div class="form-group">
				    
				    
				    
				    <div class="col-sm-10">
				    	<br>
				      	 <button type="button" class="btn btn-success" >Print</button>
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
