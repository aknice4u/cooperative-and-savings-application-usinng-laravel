@extends('Layouts.layoutSelector')
@section('pageTitle')
   COOPERATIVE SOCIETY COMMIITTEE
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
                  <div align="center"><h4 class="card-title profile-page"><b>@yield('pageTitle')</b></h4></div>
                 	
                 	<div class="row" align="center">
                 	<div class="col-md-12">
			     <table class="table table-stripped table-hover table-condensed table-responsive">
				<tr>
				    <th>S/N</th>
				    <th>NAME OF EXECUTIVE</th>
				    <th>POSITION</th>
				    <th>LOCATION</th>
				    <th>TELEPHONE NUMBER</th>
				    <th>EMAIL</th>
				</tr>
				<tbody>
				@forelse($getAllExecutive as $key => $listMgt)
				    <tr>
				    	<td> {{ 1 + $key++ }} </td>
				    	<td> {{ $listMgt->executive_name }} </td>
				    	<td> {{ $listMgt->position }} </td>
				    	<td> {{ $listMgt->location}} </td>
				    	<td> {{ $listMgt->telephone }} </td>
				    	<td> {{ ($listMgt->email) ? $listMgt->email : ' - ' }} </td>
				    </tr>
				@empty
				    <tr><td colspan="5" class="text-danger text-center">No record found !</td><tr>
				@endforelse
				</tbody>
			   </table>
			</div>
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
<!--//-->
@stop

@section('scripts')
 <!--//-->
@stop