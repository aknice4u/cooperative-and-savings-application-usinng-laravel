@extends('Layouts.layoutSelector')
@section('pageTitle')
Edit Profile
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
                  <!--Your contents go thus...-->

			<div align="center">	
			<form method="post" action="{{route('regMember')}}" id="form1">
			{{ csrf_field() }}
                    
			    <div class="form-group">
			    <div class="row">
		<div class="col-sm-5"  align="left">    
                 <label for="code" class="control-label">Please Enter Applicants Card Number or Name</label><br>
                 </div>
                 <div class="col-sm-7">
                 </div>
                 </div>
		        <div class="row">
		            
		            <div class="col-sm-6">
		       		<input type="text" id="userSearch" autocomplete="off" list="enrolledUsers" name="regNo" class="formex form-control">
		       		<datalist id="enrolledUsers">
		       		
				  @foreach($TheMember as $e)
				  
				  	<option value="{{$e->regNo}}">{{$e->regNo}}: {{$e->first_name}} {{$e->middle_name}} {{$e->last_name}}</option>
				  @endforeach
				</datalist>
		       	     </div>
		       	     <div class="col-sm-2">
                		<button style="" class="btn btn-success" >Get Applicant</button>
		 	     </div>
		 	</div>
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

<script type='text/javascript'>		

</script>
@stop