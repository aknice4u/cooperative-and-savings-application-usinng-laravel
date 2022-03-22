@extends('Layouts.layoutSelector')
@section('pageTitle')
   Monthly Contribution Computation
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
            <form id="form1" name="form1" method="post"  enctype="multipart/form-data">
	          {{ csrf_field() }}
		<label class="label-control">Select Excel File (*Note the excel file must be ".csv" extension)</label>
	        <input type="file" name="upload">
	        <input type="submit" name="upload" id="button" value="Submit" class="btn btn-success" style="margin-top: 10px;" />
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

