@extends('Layouts.layoutSelector')
@section('pageTitle')
   {{ $pagetitle }}
@stop
@section('welcomePageActive')
  active
@stop
@section('styles')
<!--//-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@stop
@section('content')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <div class="main-panel">
        <div class="content-wrapper">
          
          
       
          <div class="row">
            
                
                <div class="col-12 grid-margin stretch-card">
                  <div class="card">
                  
		               <div class="card-body">
				 <div class="row">
		          	<h2>{{ $pagetitle }}</h2>
		          	</div>
		               <br><br><br>
				<div class="row">
				<div class="col-12">
					<table class="table table-bordered table-striped table-highlight">
						<thead>
							<th rowspan="2">SN</th>
							<th rowspan="2">Fullname</th>
							<th rowspan="2">Reg Number</th>
							<th colspan="3">Old</th>
							<th colspan="3">New</th>
							<th rowspan="2"> Status </th>
							<th rowspan="2">Date Approved</th>
							<th rowspan="2">Action</th>
						</thead>
						<thead>
							<td>&nbsp</td>
							<td>&nbsp</td>
							<td>&nbsp</td>
							<td>Old Monthly Cont.</td>
							<td>Old Loan</td>
							<td>Old Interest</td>
							<td>New Monthly Cont.</td>
							<td>New Loan</td>
							<td>New Interest</td>
							<td>&nbsp</td>
							<td>&nbsp</td>
							<td>&nbsp</td>
							
						</thead>
						@php $sn = 1; @endphp
						<tbody>
							@foreach($new as $list)
								<tr>
									<td>{{ $sn++ }}</td>
									
									@php 
										$regdetails = DB::table('tblmembers')->where('regNo', $list->regno)->first();
										$old = DB::table('tbldefaultMonthlyContribution')->where('ID', $list->old_id)->first();
									@endphp
										<td>{{ $regdetails->last_name }} {{ $regdetails->first_name }} {{ $regdetails->middle_name }}</td>
										<td>{{ $list->regno }}</td>
										<td>{{ number_format($list->old_mc) }}</td>
										<td>{{ number_format($list->old_loan) }}</td>
										<td>{{ number_format($list->old_interest) }}</td>
									
									
									
										<td>{{ number_format($list->new_mc) }}</td>
										<td>{{ number_format($list->new_loan) }}</td>
										<td>{{ number_format($list->new_interest) }}</td>
									
									
									<td>
										@if($list->approved == 1)
											<span class="text-success">Approved</span>
										@else 
											<span class="text-danger">Pending</span>
										@endif
									</td>
									@php  if($list->date_approved == null){ $date = ""; } else { $date = date('d M, Y', $list->date_approved ); }@endphp
									<td>{{ $date }}</td>
									<td>
										@if($list->approved == 1)
											<a href="/print-change/{{ $list->id }}" class="btn btn-sm btn-primary">Print </a>
										@else 
											<a href="/approve-change/{{ $list->id }}" class="btn btn-sm btn-primary">Approve </a>
										@endif 
									
									</td>
									
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				</div>
                      	</form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
           </form>
          </div>
        </div>
        
        <div class="modal fade" id="z-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">
					Edit Bank
				</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">
                        &times;
                    </span>
				</button>
			</div>
            <form action="" method="post">
                <div class="modal-body">
                    {{ csrf_field() }}
                        <div class="form-group">
                            <label for="recipient-name" class="form-control-label">
                                Class group:
                            </label>
                            <input type="text" name="bank-edit" id="bank-edit" class="form-control m-input" required id="exampleSelect1">											
                            <input type="hidden" name="z-id" id="z-id">
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
@stop



@section('scripts')
  <!--//-->
  <Script>
  	$('#date').datepicker({
	    dateFormat: 'yy-mm-dd'
	});
	
	function calc(){
		c = document.getElementById('contribution').value;
		l = document.getElementById('loan').value;
		i = document.getElementById('interest').value;
		tot = Number(c) + Number(l) + Number(i);
		document.getElementById('total').value = tot;
	}
	
	function getMembers(a)
	{
		document.getElementById('the-form').submit();
	}
	
	function placeID()
	{
		if(document.getElementById('reg').value !== ""){
			document.getElementById('regno').value = document.getElementById('reg').value;
		}
	}
	
	function deleteBank(id, name){
		if(confirm('Are you sure you want to delete '+name)){
			window.location.assign('/bank-delete/'+id);
		}
	}
	
	function callModal(name, id){
		document.getElementById('bank-edit').value = name;
		document.getElementById('z-id').value = id;
		$('#z-modal').modal('show');
		return false;
	}
  </script>
@stop