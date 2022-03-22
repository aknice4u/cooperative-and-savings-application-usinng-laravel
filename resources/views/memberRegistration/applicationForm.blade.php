@extends('Layouts.loginLayout')
@section('pageTitle')
   Application Form For Membership
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
@elseif (session('warnMessage'))
    <div class="alert alert-warning">
        {{ session('warnMessage') }}
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
	          <a href="{{url('/home')}}"><button style="margin-bottom:20px" align="left" type="submit" class="btn btn-success">Go back</button></a>
                  <h4 align="center" class="card-title profile-page"><b>@yield('pageTitle')</b></h4>
                  
                  <!--Your contents go thus...-->
		
                 <form data-validate class="form-horizontal" action="{{route('saveMemberApply')}}" enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                            <div align="center" class="col-12">
                            	<div class="form-group">
				    	
            		
            		
		            		
			    		 <div id="imagewrapper" style="width: 300px;height:300px;">
			    		 <img src="{{ asset('profilePic/noImage/no_image_available.jpeg') }}" id="output_image" alt="Avatar" style="max-width: 100%;max-height: 100%;" class="image">
			    		 </div>
			    		 <input type="file" class="hidden-print" name="passport" accept="image/*" onchange="preview_image(event)">
			    		 
			    		
					
				 </div>
				
				
				<div class="col-12">
				<div class="row">
				<div class="col-md-4 col-sm-12">
                            	  <div class="form-group">
				    
				    
				    <label for="regNo">ID Card No:</label>
				    
				      <input type="text" class="form-control" name="cardNo" id="cardNo" min="0" oninput="validity.valid||(value='');" value="{{old('cardNo')}}" required/>
				    
				    
				  </div>
				  </div>
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label  for="gender">gender</label>
				    
				     
				      	<select type="text" id="gender" name="gender" class="formex form-control" required>
					<option value="">Select gender</option>
						@foreach($GenderList as $b)
					<option value="{{$b->id}}" {{old("gender") == $b->id? "selected" :"" }}>{{$b->gender}} </option>

						@endforeach
				 	</select>
				    
				    
				  </div>
				  </div>
				  
				  <div class="col-md-4 col-sm-12">
				   <div class="form-group">
				    <label for="title">Title</label>
				   
				    
				      	<select type="text" id="title" name="title" class="formex form-control" required>
					<option value="">Select Title</option>
						@foreach($TitleList as $b)
					<option value="{{$b->id}}" {{old("title") == $b->id ? "selected" :"" }}>{{$b->title}} </option>

						@endforeach
				 	</select>
				    
				   
				  </div>
				  </div>
				   <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label for="first_name">First Name:</label>
				    
				    
				      <input type="text" class="form-control" name="first_name" id="first_name" minlength="2" maxlength="30" value="{{old('first_name')}}" required/>
				    
				    
				  </div>
				  </div>
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label for="middle_name">Middle Name:</label>
				    
				     
				      <input type="text" class="form-control" name="middle_name" id="middle_name" minlength="2" maxlength="30" value="{{old('middle_name')}}" required/>
				    
				    
				  </div>
				  </div>
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label  for="last_name">Last Name:</label>
				    
				    
				      <input type="text" class="form-control" name="last_name" id="last_name" minlength="2" maxlength="30" value="{{old('last_name')}}" required/>
				    
				    
				  </div> 
				  </div>
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label  for="phoneNo">Phone Number:</label>
				    
				    
				      <input type="text" class="form-control" name="phoneNo" id="phoneNo" pattern="^[0]\d{10}$" value="{{old('phoneNo')}}" required/>
				    
				    
				  </div>
				  </div>
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label  for="email">Email:</label>
				    
				    
				      <input type="email" class="form-control" name="email" id="email" title="The domain portion of the email address is invalid (the portion after the @)." pattern="^([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22))*\x40([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d))*(\.\w{2,})+$"  value="{{old('email')}}" required/>
				    
				  </div>
				  </div>
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label for="states">State</label>
				    
				   
				      	<select type="text" id="states" name="state" class="formex form-control" required>
					<option value="">Select State</option>
						@foreach($StateList as $b)
					<option value="{{$b->StateID}}" {{old("state") == $b->StateID ? "selected" :"" }}>{{$b->State}} </option>

						@endforeach
				 	</select>
				    </div>
				    
				  </div>
				  <div class="col-md-4 col-sm-12">
				<div class="form-group">
				  	<label for="lga">L.G.A</label>
				  	
								   
					<select type="text" id="lga"  name="lga"  class="form-control formex" >
						
						@if($LgaList  != '')
						@foreach($LgaList as $l)
					  	<option value="{{$l->lgaId}}" {{old("lga") == $l->lgaId? "selected" :"" }}>{{$l->lga}} </option>
					  	@endforeach
					  	@endif
					</select>
					
					</div>
				</div>
				<div class="col-md-4 col-sm-12">
				<div class="form-group">
			              <label for="marital_state">Marital Status</label>
						 	
			              		<select name="marital_status" id="marital_status" class="form-control" value="" required>
									  <option value="" selected>Select Marital Status</option>
									  @foreach($MaritalList as $sta)
									  <option value="{{$sta->ID}}" {{old("marital_status") == $sta->ID ? "selected":""}}>{{$sta->status}}</option>
									  @endforeach
			              		</select>
			              	</div>		
			            </div>
				<div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label  for="address">Address:</label>
				    
				   
				      <textarea type="text" class="form-control" id="address" name="address" minlength="10" required>{{ old('address') }}</textarea>
				    </div>
				    
				  </div>
				<div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label  for="nok">Next of Kin:</label>
				    
				    
				      <input type="text" class="form-control" name="nok" id="nok" value="{{old('nok')}}" required/>
				    </div>
				    
				  </div>
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label  for="nok">Relationship With Next of Kin:</label>
				    
				    
				      <input type="text" class="form-control" name="rnok" id="rnok" value="{{old('rnok')}}" required/>
				    </div>
				    
				  </div>
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label  for="address">Next of Kin&apos;s Address:</label>
				    
				     
				      <textarea type="text" class="form-control" id="nokaddress" name="nokaddress" minlength="10" required>{{ old('nokaddress') }}</textarea>
				    </div>
				    
				  </div>
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label  for="phoneNo">Next of Kin&apos;s Phone Number:</label>
				    
				    
				      <input type="text" class="form-control" name="nokphoneNo" id="nokphoneNo" pattern="^[0]\d{10}$" value="{{old('nokphoneNo')}}" required/>
				    </div>
				    
				    
				  </div>
				  <div class="col-md-4 col-sm-12">
				  
				  <div class="form-group">
				    <label  for="monthbution">Monthly Savings:</label>
				   
				    
				      <input type="number" class="form-control" name="monthbution" id="monthbution" min="0" oninput="validity.valid||(value='');" value="{{old('monthbution')}}" required/>
				    </div>
				    
				  </div>
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label for="division">Branch/Division</label>
				    
				     
				 	<select type="text" id="division" name="division" class="formex form-control" required >
					<option value="">Select Division</option>
						@foreach($DivisionList as $b)
					<option value="{{$b->ID}}" {{old("division") == $b->ID? "selected" :"" }}>{{$b->division}} </option>

						@endforeach
				 	</select>
				 	
				    </div>
				  </div>
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label  for="address">Bank</label>
				    
				    
				 	<select type="text" id="bank" name="bank" class="formex form-control" required >
					<option value="">Select Bank</option>
						@foreach($BankList as $b)
					<option value="{{$b->ID}}" {{old("bank") == $b->ID? "selected" :"" }}>{{$b->bank}} </option>

						@endforeach
				 	</select>
				 	
				    </div>
				  </div>
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label  for="accNo">Account Number:</label>
				    
				     
				      <input type="number" class="form-control" name="accNo" id="accNo" min="0" oninput="validity.valid||(value='');" value="{{old('accNo')}}" required/>
				    </div>
				    
				  </div>
				  <div class="col-md-4 col-sm-12">
				  <div class="form-group">
				    <label  for="employmentDate">Date of Employment:</label>
				   
				   
				      <input type="text" name="employmentDate" id="employmentDate" class="form-control input-lg" value="{{old('employmentDate')}}"  required readonly/> 
				    </div>
				    
				  </div>
				  
				  <div class="form-group"> 
				    <div class="col-sm-offset-2 col-sm-10">
				      <button type="submit" class="btn btn-success">Submit</button>
				    </div>
				  </div>
				  </div>
				  </div>
				  </div>
			  </form>
			<p align="center " id="warningText" class="hidden-print">Please be advised: You cannot edit your information after you submit, unless you contact us directly</p>
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
<style type="text/css">
#warningText{

color:red;
}
</style>

@stop

@section('scripts')
 <script src="{{asset('assets/js/validate.js')}}"></script>
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>

<script type='text/javascript'>		
$('#employmentDate').datepicker({
    dateFormat: 'yy-mm-dd'
});  

		
 $(document).ready(function() {
		//alert('OK');
	//var state = document.getElementById("states");	
	var state = $('#states').val();
 	
      $token = $("input[name='_token']").val();
        $.ajax({
           headers: {'X-CSRF-TOKEN': $token},
            type: 'POST',
            url: murl + "/get-local-government",
            data: {'id': state},
            success: function(datas){
                $('#lga');
           //console.log(datas);
           $('#lga').append( '<option value="">Select One</option>' );
    $.each(datas, function(index, obj){
        $('#lga').append( '<option value="'+obj.lgaId+'">'+obj.lga+'</option>' );
        });
		
	    }

		});	
		
		
		
  $('#states').change(function(){
      var state = $(this).val();
      //alert(state);
      $token = $("input[name='_token']").val();
        $.ajax({
           headers: {'X-CSRF-TOKEN': $token},
            type: 'POST',
            url: murl + "/get-local-government",
            data: {'id': state},
            success: function(datas){
                $('#lga').empty();
           //console.log(datas);
         
    $.each(datas, function(index, obj){
        $('#lga').append( '<option value="'+obj.lgaId+'">'+obj.lga+'</option>' );
        });
		
	    }

		});

  });

});

function preview_image(event) 
    { 
     var reader = new FileReader();
     reader.onload = function()
     {
      var output = document.getElementById('output_image');
      output.src = reader.result;
     }
     reader.readAsDataURL(event.target.files[0]);
    } 
    
 

    
     
</script>
@stop