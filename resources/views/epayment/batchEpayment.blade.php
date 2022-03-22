@extends('Layouts.layoutSelector')

@section('pageTitle')
E-payment For Batch : {{$current_batch}}
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
      



      
        <div class="col-sm-12">
      
      <h3 class="text-center"> Multi-purpose Cooperative Society Ltd.</h3>
       <h4 class="text-center">Epayment</h4>
       <h4 class="text-center">Batch Number: {{$current_batch}}</h4>
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
              <th>Beneficiary</th>
              <th class="text-center">Amount ( &#8358;)</th>
              <th>Account No</th>
              <th>Bank</th>
             </tr>
          </thead>
          <tbody>
            @php $key = 1; @endphp
         @foreach($viewBatch as $list)
          <tr>
            <td>{{$key++}}</td>
            <td>{{$list->beneficiary}}</td>
            <td class=" text-right" style="">{{number_format($list->amount,2)}}</td>
            <td>{{$list->accountNo}}</td>
            <td>{{$list->bank}}</td>

          </tr>
         @endforeach
          <tr>
            <td><strong>TOTAL</strong></td>
            <td></td>
            <td class="text-right"><strong>{{number_format($sum,2)}}</strong></td>
            <td></td>
            <td></td>

          </tr>
          </tbody>
        </table>
             </form>
        </div>
        <br />

      <!-- /.col -->
    </div>
    

<!-- new layout -->
</div>
</div>
</div>


</div>
</div>
</div>
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
        var dateFormatted = $.datepicker.formatDate('dd MM yy', theDate);
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
        var dateFormatted = $.datepicker.formatDate('dd MM yy', theDate);
        $("#dateFrom").val(dateFormatted);
          },
    });

  } );

  </script>
  @endsection
