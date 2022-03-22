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

<div class="container-fluid page-body-wrapper" style="width:100%;">
      <div class="main-panel" style="width:100%;">
        <div class="content-wrapper" style="width:100%;">
          <div class="rows">

<div class="col-md-12 col-xs-12 col-ms-12 grid-margin grid-margin-md-0 stretch-card">
              <div class="card" style="width:100%;">
                <div class="card-body" style="width:100%;">


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


            </div>


<div class="rows">
<div class="col-md-12">
  <h2 class="text-center" style="margin-bottom:20px;">ALL LOAN REQUEST</h2>
  <form class="" action="" method="post" >

        {{ csrf_field() }}
  <table class="table table-striped table-responsive">
         <thead>
         <tr>
         <th>SN</th>
         <th>Name</th>
         <th>Amount Requesting</th>
         <th>Repay Period</th>
         <th>Loan Repay Amount</th>
         <th>Interest Repay Amount</th>
         <th>Bank</th>
         <th>Account No</th>
         <th>Guarantor</th>
         
         <th>View</th>
         <th>Push To President</th>
	 
         

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
      <td>{{$list->bank}}</td>
      <td>{{$list->account_num}}</td>
      <td>@if($guarantor !=""){{$guarantor->first_name}} {{$guarantor->middle_name}} {{$guarantor->last_name}}@endif</td>
       
      
      
      <td><a href="javascript:void()" id="{{$list->loanID}}"  class="btn btn-success view"><i class="fa fa-eye"></i></a></td>
      <td> <a href="javascript:void()" id="{{$list->loanID}}" class="btn btn-success push push{{$list->loanID}}">Push</a></td>
      
     </tr>
  		@endforeach
         </tbody>
         </table>
         
</form>
<div class="pagination">{{$allrequest->links()}}</div>
 </div>
</div>

<!-- Modal -->

    <div id="myModal" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">
 <h4 class="modal-title text-center">LOAN REQUEST DETAILS</h4>
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                   

                </div>

                <div class="modal-body">

  <table class="table">
  <tr>
    <th scope="row" style="width:50%;padding-top:8px;padding-bottom:8px;">Full Name</th>
    <td style="padding-left:25px; padding-top:8px;padding-bottom:8px; text-transform:uppercase;"><p class="name"></p></td>
  </tr>
  <tr>
    <th scope="row" style="padding-top:8px;padding-bottom:8px;">Amount Requested</th>
    <td style="padding-left:25px;padding-top:8px;padding-bottom:8px; text-transform:uppercase;"><p class="amount"></p></td>
  </tr>
  <tr>
    <th scope="row" style="padding-top:8px;padding-bottom:8px;">Duration of Repayment</th>
    <td style="padding-left:25px;padding-top:8px;padding-bottom:8px; text-transform:uppercase;"><p class="period"></p></td>
  </tr>
  <tr>
    <th scope="row" style="padding-top:8px;padding-bottom:8px;">Loan Repayment/Month</th>
    <td style="padding-left:25px;padding-top:8px;padding-bottom:8px; text-transform:uppercase;"><p class="loanrepay"></p></td>
  </tr>
  <tr>
    <th scope="row" style="padding-top:8px;padding-bottom:8px;">Interest Repayment/Month</th>
    <td style="padding-left:25px;padding-top:8px;padding-bottom:8px; text-transform:uppercase;"><p class="interestrepay"></p></td>
  </tr>
  <tr>
    <th scope="row" style="padding-top:8px;padding-bottom:8px;">Bank</th>
    <td style="padding-left:25px;padding-top:8px;padding-bottom:8px; text-transform:uppercase;"><p class="bank"></p></td>
  </tr>
  <tr>
    <th scope="row" style="padding-top:8px;padding-bottom:8px;">Account Number</th>
    <td style="padding-left:25px;padding-top:8px;padding-bottom:8px; text-transform:uppercase;"><p class="acctno"></p></td>
  </tr>
  <tr>
    <th scope="row" style="padding-top:8px;padding-bottom:8px;">Guarantor</th>
    <td style="padding-left:25px;padding-top:8px;padding-bottom:8px; text-transform:uppercase;"><p class="guarantor"></p></td>
  </tr>
    <tr>
    <th scope="row" style="padding-top:8px;padding-bottom:8px;">Date Requested</th>
    <td style="padding-left:25px;padding-top:8px;padding-bottom:8px; text-transform:uppercase;"><p class="date"></p></td>
  </tr>
</table>
<h3> Purpose of Loan</h3>
<div class="purpose">

</div>


                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                </div>

            </div>

        </div>

    </div>

<!-- End Modal View-->


<!-- Modal Approve-->

    <div id="rejectModal" class="modal fade ">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  
                </div>
  <h4 class="modal-title">LOAN REJECTION REASON</h4>
                <form method="post" action="{{url('/reject-request')}}">
                    {{ csrf_field() }}
                <div class="modal-body">
                <input type="hidden" name="id" id="loanId" />
                <label class="label-control">Reason for Rejecting</label>
                <textarea name="reason" class="form-control">

                </textarea>
                </div>

                <div class="modal-footer">
                  <input type="submit" name="submit" value="Submit" class="btn btn-success">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </form>

            </div>

        </div>

    </div>

<!-- End Modal Approve-->



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
<link rel="stylesheet" href="{{asset('assets/font-awesome/css/font-awesome.min.css')}}">
<style type="text/css">
.table-responsive tr td, .table-responsive tr th
{
font-size: 11px;
}
.pagination li
{
padding: 6px;
}
</style>
@stop

@section('scripts')

<script type="text/javascript" src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>

<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}" ></script>
<script type="text/javascript">
  $( function() {
      $("#enddate").datepicker({
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
        $("#enddate").val(dateFormatted);
          },
    });

  } );


   $( function() {
      $("#startdate").datepicker({
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
        $("#startdate").val(dateFormatted);
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
          var theDate = new Date(Date.parse($(this).datepicker('getDate')));
        var dateFormatted = $.datepicker.formatDate('dd MM yy', theDate);
        $(".datePick").val(dateFormatted);
          },
    });

  } );

</script>
<script type="text/javascript">
function ConfirmDelete()
{
  return confirm("Are you sure you want to delete?");


}
</script>

<script type="text/javascript">
  $(document).ready(function(){
$('#amount').mouseout(function()
{
  var amount = $(this).val();

$.ajax({
  url: murl +'/calculate/loan-interest',
  type: "post",
  data: {'amt': amount, '_token': $('input[name=_token]').val()},
  success: function(data){
  console.log(data.title);
   $('#interest').val(data);
  }
});

$("#myModal").modal('show');


})

  });
</script>

<script>

(function () {

  $('#division').change( function(){
    //$('#processing').text('Processing. Please wait...');
    $.ajax({
      url: murl +'/get-members',
      type: "post",
      data: {'division': $('#division').val(), '_token': $('input[name=_token]').val()},

      success: function(data){

    $('#guarantor').empty();
        $('#guarantor').append( '<option value="">Select Guarantor</option>' );
        $.each(data, function(index, obj){
        $('#guarantor').append( '<option value="'+obj.regNo+'">'+obj.last_name+' '+obj.middle_name+' '+obj.first_name+'</option>' );
        });

      }
    })
  });}) ();

</script>

<script>

(function () {

  $('#months').change( function(){
    //$('#processing').text('Processing. Please wait...');

    var amount = $('#amount').val();
    var contribution = $('#contribution').val();
    $.ajax({
      url: murl +'/calculate/monthly-repay',
      type: "post",
      data: {'months': $('#months').val(),'amount':amount,'contribution':contribution, '_token': $('input[name=_token]').val()},

      success: function(data){
          console.log(data);
       $('#loanMonthly').val(data.monthly_loan);
       $('#interestMonthly').val(data.monthly_interest);
       $('#totalrepay').val(data.monthly_repay);
       $('#total').val(data.total);
      }
    })
  });}) ();

</script>

<script>

$(document).ready(function()
{

  $('.push').click( function(){
    //$('#processing').text('Processing. Please wait...');

    var id = $(this).attr('id');
    var check = 'treasurer';
    //alert(id);
    $.ajax({
      url: murl +'/approval-steps/update',
      type: "post",
      data: {'id': id, 'moveTo':check, '_token': $('input[name=_token]').val()},

      success: function(data){
          console.log(data);
      alert(data);
       $(".push"+id).hide();
      }
    });
    
  });
  });

</script>


    <script>

    (function () {

      $('.view').click( function(){
        //$('#processing').text('Processing. Please wait...');

        var id = $(this).attr('id');
        //var contribution = $('#contribution').val();
        $.ajax({
          url: murl +'/loan/details',
          type: "post",
          data: {'id': id, '_token': $('input[name=_token]').val()},

          success: function(data){
              console.log(data);
              var n = data.first_name+' '+data.middle_name+' '+data.last_name;
           var amount = data.amount;
           var loanpermonth = data.loan_repay;
           var interestpermonth = data.interest_repay;
           $('.name').html(n);
           $('.amount').html(amount.toLocaleString());

           $('.period').html(data.period);
           $('.loanrepay').html(loanpermonth.toLocaleString());
           $('.interestrepay').html(interestpermonth.toLocaleString());
           $('.bank').html(data.bank);
           $('.acctno').html(data.account_num);
           $('.purpose').html(data.purpose);
            $('.date').html(data.date_updated);
          }
        })
      });}) ();

      (function () {

        $('.view').click( function(){
          //$('#processing').text('Processing. Please wait...');

          var id = $(this).attr('id');
      $.ajax({
        url: murl +'/guarantor/details',
        type: "post",
        data: {'id': id, '_token': $('input[name=_token]').val()},

        success: function(data){
            console.log(data);
            var g = data.first_name+' '+data.middle_name+' '+data.last_name;
         $('.guarantor').html(g);

        }
      })
    });}) ();

    </script>

    <script type="text/javascript">
    function ConfirmApprove()
    {
      return confirm("Are you sure you want to Approve this Loan Request?");
    }

    $(document).ready(function(){

        $(".view").click(function(){

            $("#myModal").modal('show');

        });

        $(".reject").click(function(){
         var id = $(this).attr('id');
         $('#loanId').val(id);
            $("#rejectModal").modal('show');

        });

    });

    </script>

    <script>

    (function () {

      $('.table tbody tr td .approve').click( function(){
        var id = $(this).attr('id');
        var dt = $('.datePick').val();
        
//alert(dt);
        $.ajax({
          url: murl +'/approve-request',
          type: "post",
          data: {'id': id,'date':dt, '_token': $('input[name=_token]').val()},

          success: function(data){
            location.reload(true);
          }
        });

  });}) ();

    </script>



@stop
