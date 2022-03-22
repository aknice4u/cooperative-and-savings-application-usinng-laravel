@extends('Layouts.layoutSelector')

@section('pageTitle')
E-payment Schedule
@endsection

@section('content')
<div class="container-fluid page-body-wrapper" style="">
      <div class="main-panel" style="">
        <div class="content-wrapper" style="padding-left:0px;padding-right:0px;">
          <div class="rows">

<div class="col-md-12 col-xs-12 col-ms-12 grid-margin grid-margin-md-0 stretch-card" style="padding-left:0px;padding-right:0px;">
              <div class="card" style="padding-left:0px;padding-right:0px;">
                <div class="card-body" style="padding-left:0px;padding-right:0px;">



        @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <strong>Error!</strong> <br />
          @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>
          @endforeach
        </div>
        @endif

        @if(session('msg'))
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <strong>Success!</strong> <br />
          {{ session('msg') }}
        </div>
        @endif

        @if(session('err'))
        <div class="alert alert-warning alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <strong>Operation Error !</strong> <br />
          {{ session('err') }}
        </div>
        @endif
      

<!--search all vouchers-->
        <div class="row hidden-print">
          <div class="col-md-12">
          <form method="post" action="{{url('/batch/search')}}">
<div class="col-md-12">
<div class="row">
          <div class="col-md-5">
                {{ csrf_field() }}

                  <label>Date From</label>
                  <input type="text" name="dateFrom" class="form-control" id="dateFrom" value="@if(session('from')!=""){{session('from')}} @endif">
             </div>
               <div class="col-md-5" style="padding-right: 0px;">
                  <label>Date To</label>
                  <input type="text" name="dateTo" class="form-control" id="dateTo" value="@if(session('to')==""){{date('Y-m-d')}}@else {{session('to')}} @endif">
             </div>

               <div class="col-md-1" style="padding-left: 0px; margin-top: 8px;">
                <label></label>
                 <input type="submit" name="submit" class="btn btn-success">
               </div>
</div>
</div>
              </form>

            </div>

        </div>
      
        <!--Search all vouchers-->

      
        <div class="col-sm-12 " style="margin-top:20px;">
      <h2 class="text-center">Multi-purpose Cooperative Society Ltd.</h2>
       <h2 class="text-center">Epayment Batches</h2>
      <br />



         <!-- 1st column -->


      <br />
      <div>
        <form action="{{url('/cpo/restore')}}" method="post">
            {{ csrf_field() }}
        <table id="myTable" class="table table-bordered" cellpadding="10">
          <thead>
            <tr>
              <th>S/N</th>
              <th>Batch</th>
              <th class="text-center">Amount ( &#8358;)</th>
              <th class="hidden-print"></th>
            </tr>
          </thead>
          <tbody>
            @php $key = 1; @endphp
         @foreach($allPayments as $list)
          <tr>
            <td>{{$key++}}</td>
            <td>{{$list->batch}}</td>
            <td class="text-center">{{number_format($list->sum,2)}}</td>

             <td class="hidden-print"><a href="{{url("/epayment/view-epayment/$list->batch")}}" class="btn btn-success">View</a></td>
          </tr>
         @endforeach

          </tbody>
        </table>
             </form>
        </div>
        <br />

      <!-- /.col -->
    </div>
    

  <!-- Modal HTML -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
                <div id="desc"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
<!--///// end modal -->


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

  <style type="text/css">
    .status
    {
      font-size: 15px;
      padding: 0px;
      height: 100%;

    }

    .textbox {
    border: 1px;
    background-color: #66FFBA;
    outline:0;
    height:25px;
    width: 275px;
  }


  .autocomplete-suggestions{
    color:#66FFBA;
    height:125px;
  }
    .table,tr,td{
        border: #9f9f9f solid 1px !important;
        font-size: 12px !important;
    }
     .table thead tr th
     {
      font-weight: 700;
      font-size: 17px;
      border: #9f9f9f solid 1px
     }
  </style>

  @endsection


@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{asset('/assets/js/daterangepicker.js')}}"></script>
  <script type="text/javascript">
    $( function() {
      $("#dateTo").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: '1910:2090', // specifying a hard coded year range
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: "dd MM, yy",
        //dateFormat: "D, MM d, yy",
        onSelect: function(dateText, inst){
          var theDate = new Date(Date.parse($(this).datepicker('getDate')));
        var dateFormatted = $.datepicker.formatDate('yy-mm-dd', theDate);
        $("#dateTo").val(dateFormatted);
          },
    });

  } );

$( function() {
      $("#dateFrom").datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: '1910:2090', // specifying a hard coded year range
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: "dd MM, yy",
        //dateFormat: "D, MM d, yy",
        onSelect: function(dateText, inst){
          var theDate = new Date(Date.parse($(this).datepicker('getDate')));
        var dateFormatted = $.datepicker.formatDate('yy-mm-dd', theDate);
        $("#dateFrom").val(dateFormatted);
          },
    });

  } );

  </script>
  @endsection
