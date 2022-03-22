@extends('Layouts.layoutSelector')
@section('pageTitle')
  All Loan Requests
@endsection

<style type="text/css">
    .form-horizontal
    {
        padding: 26px;
    }

    .form-horizontal .col-md-12 .col-md-4, .form-horizontal .col-md-12 .col-sm-4, .form-horizontal .col-md-12 .col-md-6 {
      padding-right: 20px;
    }
    .table tr th
    {
      background: #00a65a;
      color:#FFF;
      text-transform: uppercase;
      font-size: 14px;
    }

</style>

@section('content')
<div class="container-fluid page-body-wrapper">
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="rows">

<div class="col-md-12 col-xs-12 col-ms-12 grid-margin grid-margin-md-0 stretch-card">
              <div class="card">
                <div class="card-body">
                <h2 class="modal-title text-center" style="padding-bottom:15px;">LOAN COLLECTION HISTORY</h2>


<div class="col-md-12">
                @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Error!</strong>
                    @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                @if(session('msg'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Success!</strong>
                    {{ session('msg') }}
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Success!</strong>
                    {{ session('error') }}
                </div>
                @endif
                @php
                $y = date('Y');
                $date1= "01-01-$y";
                $date2 = "31-12-$y";
                @endphp
              <form action="{{url('/loan-history/list')}}" method="post">
                {{ csrf_field() }}
                <div class="row">
                          <div class="col-md-5">
                            <div class="form-group">
                              <label for="date">Start Date</label>
                              <input type="text" name="dateFrom" id="getFrom" class="form-control input-lg" value="@if(session('fromDate') == ''){{$date1}}@else {{session('fromDate')}}@endif" required>
                            </div>
                          </div>
                          <div class="col-md-5">
                            <div class="form-group">
                              <label for="date">End Date</label>
                               <input type="text" name="dateTo" id="getTo" class="form-control input-lg" value="@if(session('toDate') == ''){{$date2}}@else {{session('toDate')}}@endif" required>
                            </div>
                          </div>

                              <div class="col-sm-2">
                                  <div class="form-group">
                                      <label >&nbsp;</label>
                                      <div>
                                      <button type="submit" class="btn btn-success input-lg" style="border: #333; border-radius: 0; outline: none !important; margin-left: -25px; padding: 10px;"><i class="fa fa-search"></i> Display</button>
                                      </div>
                                  </div>
                              </div>
                       </div><!-- End Row -->

            </div>
          </form>


<div class="rows">
<div class="col-md-12">
  <form class="" action="" method="post" >

        {{ csrf_field() }}
  <table class="table table-striped">
         <thead>
         <tr>
         <th>SN</th>
         <th>Name</th>
         <th>Loan Amount</th>
         <th>Repay Period</th>
         <th>Loan Repay Amount</th>
         <th>Interest Repay Amount</th>
         <th>Approved Date</th>
         <th></th>
         </thead>
         <tbody>
         @php $k= 1; @endphp
         @foreach($allrequest as $list)
         @php
         $guarantor = DB::table('tblmembers')->where('regno','=',$list->gaurantor)->first();
         @endphp
  		<tr>
  		<td>{{$k++}}</td>
  		<td>{{$list->first_name}} {{$list->middle_name}} {{$list->last_name}}</td>
  		<td>{{number_format($list->amount,2)}}</td>
  		<td>{{$list->period}} Months</td>
  		<td>{{$list->loan_repay}}</td>
      <td>{{$list->interest_repay}}</td>
      <td>  <input type="text" id="date" name="date" class="form-control datePick" style="width:130px" value="{{date('d-m-Y', strtotime(trim($list->approved_date)))}}"></td>
       <td> <a href="javascript:void()" id="{{$list->loanID}}" onclick="return ConfirmApprove()" class="btn btn-success update msg{{$list->loanID}}"> Update </a></td>

  		</tr>
  		@endforeach
      <tr>
        <td><strong>Total Amount</strong></td>
        <td></td>
      <td><strong>{{number_format($sum,2)}}</strong></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
         </tbody>
         </table>

</form>
<button id="btnExport" class="btn btn-success" onclick="javascript:xport.toCSV('tableData');"> Export to Excel</button>


 </div>
 <div class="pagination"> {{$allrequest->links()}}</div>
</div>

<table class="table table-striped" id="tableData" style="display:none;">
       <thead>
       <tr>
       <th>SN</th>
       <th>Name</th>
       <th>Loan Amount</th>
       <th>Repay Period</th>
       <th>Loan Repay Amount</th>
       <th>Interest Repay Amount</th>
       <th>Approved Date</th>
       </thead>
       <tbody>
       @php $k= 1; @endphp
       @foreach($allrequest as $list)
       @php
       $guarantor = DB::table('tblmembers')->where('regno','=',$list->gaurantor)->first();
       @endphp
    <tr>
    <td>{{$k++}}</td>
    <td>{{$list->first_name}} {{$list->middle_name}} {{$list->last_name}}</td>
    <td>{{number_format($list->amount,2)}}</td>
    <td>{{$list->period}} Months</td>
    <td>{{$list->loan_repay}}</td>
    <td>{{$list->interest_repay}}</td>
    <td>{{$list->approved_date}}</td>


    </tr>
    @endforeach

       </tbody>
       </table>


<!-- new layout -->
</div>
</div>
</div>


</div>
</div>
</div>
</div>

@endsection


@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/datepicker.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/custom-style.css')}}">

<style>
 .pagination
    {
        margin-top: 15px;
    }
    .pagination li a 
    {
        padding: 10px;
        margin-top: 15px;
    }
</style>
@stop

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('assets/js/exportExcel.js')}}"></script>
    <script>


     var $btnDLtoExcel = $('#DLtoExcel-2');
        $btnDLtoExcel.on('click', function () {
            $("#tableData").excelexportjs({
                containerid: "tableData"
                , datatype: 'table'
            });

        });

    </script>
    
    <script type="text/javascript">
  $( function() {
      $("#getFrom").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: '1910:2090', // specifying a hard coded year range
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: "dd MM, yy",
        //dateFormat: "D, MM d, yy",
        onSelect: function(dateText, inst){
          var theDate = new Date(Date.parse($(this).datepicker('getDate')));
        var dateFormatted = $.datepicker.formatDate('dd MM yy', theDate);
        $("#getFrom").val(dateFormatted);
          },
    });

  } );


   $( function() {
      $("#getTo").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: '1910:2090', // specifying a hard coded year range
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: "dd MM, yy",
        //dateFormat: "D, MM d, yy",
        onSelect: function(dateText, inst){
          var theDate = new Date(Date.parse($(this).datepicker('getDate')));
        var dateFormatted = $.datepicker.formatDate('dd MM yy', theDate);
        $("#getTo").val(dateFormatted);
          },
    });

  } );
  
  $( function() {
      $(".datePick").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: '1910:2090', // specifying a hard coded year range
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: "dd MM, yy",
        //dateFormat: "D, MM d, yy",
        onSelect: function(dateText, inst){
        var id = $(this).attr('id');
        var theDate = new Date(Date.parse($(this).datepicker('getDate')));
        var dateFormatted = $.datepicker.formatDate('dd MM yy', theDate);
        $(".date+id").val(dateFormatted);
          },
    });

  } );
  
  </script>
  
  <script>

    (function () {

      $('.table tbody tr td .update').click( function(){
        var id = $(this).attr('id');
        var dt = $(this).parent().parent().find("input:eq(0)").val();
         $(".msg" + id).html("Updating.....");
        //alert(dt);
        $.ajax({
          url: murl +'/update-loan-date',
          type: "post",
          data: {'id': id,'date':dt, '_token': $('input[name=_token]').val()},

          success: function(data){
           $(".msg" + id).html(data);
          }
        });

  });}) ();

    </script>


@stop
