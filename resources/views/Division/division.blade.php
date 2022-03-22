@extends('Layouts.layoutSelector')
@section('pageTitle')
   Add a Division
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
	          
                  <h3 class="card-title profile-page"><b>@yield('pageTitle')</b></h3>
                  <!--Your contents go thus...-->
                  
		<form action="{{route('addDivision')}}" method="post" id="the-form">
                      		{{ csrf_field() }}
                      		
                      		
                      		<div class="row">

					<div class="col-6">
	                      		 <div class="form-group">
					      <label for="contribution">Division Name</label>
					      <input type="text" class="form-control" id="divisionName" name="divisionName"  placeholder="Enter Division">
					      
					    </div>
					</div>
					
					
				</div>
				<div class="row">
				<div class="col-6">
					<button class="btn btn-primary" type="submit">Add Division</button>
				</div>
				</div>
				<br><br><Br>
				<div class="row">
				<div class="col-12">
					<table class="table table-stiped">
						<thead>
							<th>SN</th>
							<th>Bank Name</th>
							<th>Action</th>
						</thead>
						@php $sn = 1; @endphp
						<tbody>
							@foreach($divisions as $list)
								<tr>
									<td>{{ $sn++ }}</td>
									<td>{{ $list->division }}</td>
									<td><a style="color: white;" href="{{url('/division-delete/'.$list->ID)}}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this division?');" >Delete</a> &nbsp &nbsp 
									<a  style="color: white;" class="btn btn-sm btn-info" onclick="return editFunc({{$list->ID}},'{{$list->division}}')">Edit</a> </td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				</div>
                      	</form>
                 

                  <!--//-->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
   <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">
					Edit Division
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        &times;
                    </span>
				</button>
			</div>
            <form method="post" role="form" action="{{route('updateDivision')}}">
                <div class="modal-body">
                    {{ csrf_field() }}
                        <div class="form-group">
                            <label for="recipient-name" class="form-control-label">
                               Division
                            </label>
                            <input type="text" name="divisionChange" id="divisionChange" class="form-control m-input" required >											
                            <input type="hidden" name="divisionid" id="divisionid">
                        </div>
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                </div>
            </form>
		</div>
    </div>
</div>

<!-- content-wrapper ends -->
<script >
function editFunc(x,y)
    {
    $('#divisionid').val(x);
     $('#divisionChange').val(y);
     $("#editModal").modal('show');
    
    }
</script>
@stop

@section('styles')

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


@stop





