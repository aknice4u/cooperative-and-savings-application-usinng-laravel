@extends('Layouts.layoutSelector')

@section('pageTitle')
Restore Payment
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
      

 
        <div class="col-sm-12 hidden-print">
        <h2 class="text-center">Multi-purpose Cooperative Society Ltd.</h2>
          <br />

        <!--search all vouchers-->
        <div class="row hidden-print">
              <div class="col-sm-6">

            </div>

          <div class="col-sm-6">

         </div>
        </div>
        <!--Search all vouchers-->

         <!-- 1st column -->


      <br />
      <div>
        <form action="{{url('/epayment/restore')}}" method="post">
            {{ csrf_field() }}
        <table id="myTable" class="table table-bordered" cellpadding="10">
          <thead>
            <tr>
              <th>S/N</th>
              <th>Beneficiary</th>
              <th class="text-center">Amount ( &#8358;)</th>
              <th>Account No</th>
              <th>Bank</th>
              <th colspan="3"> Check For Payment</th>
            </tr>
          </thead>
          <tbody>
            @php $key = 1; @endphp
         @foreach($to_restore as $list)
          <tr>
            <input type="hidden" name="id[]"  value="{{$list->loanID}}"/>
            <input type="hidden" name="beneficiary[]"  value="{{$list->first_name}} {{$list->middle_name}} {{$list->last_name}}"/>
            <input type="hidden" name="amount[]"  value="{{$list->amount}}"/>
            <input type="hidden" name="accountNo[]"  value="{{$list->account_no}}"/>
            <input type="hidden" name="bank[]"  value="{{$list->bank}}"/>
            <td>{{$key++}}</td>
            <td>{$list->first_name}} {{$list->middle_name}} {{$list->last_name}}</td>
            <td class="text-center">{{number_format($list->amount,2)}}</td>
            <td>{{$list->account_no}}</td>
            <td>{{$list->bank}}</td>
            <td>

              <input type="checkbox" name="checkname[]" value="{{$list->loanID}}">
            </td>
          </tr>

         @endforeach

          </tbody>
        </table>
         <input type="submit" name="submit" value="Confirm" style="margin-left: 10px;margin-right: 10px;" class="btn btn-success pull-right hidden-print">
        <input type="submit" name="submit" value="Restore" class="btn btn-success pull-right">
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
