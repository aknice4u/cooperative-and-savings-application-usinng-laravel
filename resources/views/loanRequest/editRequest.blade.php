@extends('Layouts.layoutSelector')
@section('pageTitle')
    Loan Request Form
@endsection

<style type="text/css">
    .form-horizontal
    {
        padding: 26px;
    }

    .form-horizontal .col-md-12 .col-md-4, .form-horizontal .col-md-12 .col-sm-4, .form-horizontal .col-md-12 .col-md-6 {
      padding-right: 20px;
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

<form class="form-horizontal" action="{{url('/my-request/update')}}" method="post" >

      {{ csrf_field() }}
      <div class="col-md-12" style="padding-left: 26px; padding-right:26px;">
<div class="row">
        <div class="col-sm-4" style="">
         <div class="form-group">
          <label for="title" >First Name</label>
          <input type="hidden" name="loanId" value="{{$requestID}}" >
            <input type="text" name="firstName" class="form-control" id="firstname" readonly required value="{{$member->first_name}}">
        </div>
       </div>

       <div class="col-sm-4">
        <div class="form-group">
         <label for="title" >Middle Name</label>
           <input type="text" name="middleName" class="form-control" id="middlename" readonly required value="{{$member->middle_name}}">
       </div>
      </div>

      <div class="col-sm-4">
       <div class="form-group">
        <label for="title" >Surname</label>
          <input type="text" name="surname" class="form-control" id="surname" readonly required value="{{$member->last_name}}">
      </div>
     </div>
</div>

        </div>

        <div class="col-md-12" style="padding-left: 26px; padding-right:26px;">
<div class="row">
          <div class="col-md-4">
        <div class="form-group" >
          <label for="title" >Monthly Contribution</label>
          <input type="text" name="contribution" class="form-control" id="contribution" readonly required value="{{$member->monthly_contribution}}">
        </div>
      </div>

      <div class="col-md-4">
       <div class="form-group">
        <label for="title" >Loan Amount</label>
          <input type="text" name="amount" class="form-control" id="amount" required value="{{$myrequest->amount}}">
      </div>
     </div>

     <div class="col-md-4">
      <div class="form-group">
       <label for="title" >Loan Interest</label>
         <input type="text" name="interest" class="form-control" id="interest" readonly required value="{{$loanInterest}}">
     </div>
    </div>
</div>
        </div>




        <div class="col-md-12" style="padding-left: 26px; padding-right:26px;">
<div class="row">
          <div class="col-md-4">
           <div class="form-group">
            <label for="title" >Purpose</label>
            <textarea class="form-control" name="purpose">{{$myrequest->purpose}}</textarea>
          </div>
         </div>

         <div class="col-md-4">
          <div class="form-group">
           <label for="title" >Bank</label>
             <select class="form-control input-lg" name="bank">
               <option>Select Bank</option>
               @foreach($banks as $list)
               @if($list->ID == $myrequest->bankid)
               <option value="{{$list->ID}}" selected>{{$list->bank}}</option>
               @else
               <option value="{{$list->ID}}">{{$list->bank}}</option>
               @endif
               @endforeach
            </select>
         </div>
        </div>

        <div class="col-md-4">
         <div class="form-group">
          <label for="title" >Account Number</label>
          <input type="text" name="accountNumber" class="form-control input-lg" id="acctNo" required value="{{$myrequest->account_no}}">
        </div>
       </div>
</div>
        </div>
        
        
        
        
         <!-- department and Designation -->
        
           <div class="col-md-12" style="padding-left: 26px; padding-right:26px;">
 <div class="row">
         <div class="col-md-6">
          <div class="form-group">
           <label for="title" >Department</label>
             <select class="form-control input-lg" name="department" id="department">
              <option >Select</option>
              @foreach($depart as $list)
              @if($list->Id == $myrequest->department)
              <option value="{{$list->Id}}" selected>{{$list->department}} </option>
              @else
             <option value="{{$list->Id}}">{{$list->department}}</option>
             @endif
             @endforeach
            </select>
         </div>
        </div>

        <div class="col-md-6">
         <div class="form-group">
          <label for="title" >Designation</label>
          <select class="form-control input-lg" name="designation" id="designation">
           <option value="">Select</option>
         
           @foreach ($desig as $list)
              @if($list->Id == $myrequest->designation)
           <option value="{{$list->Id}}" selected>{{$list->designation}} </option>
@else
<option value="{{$list->Id}}">{{$list->designation}}</option>
@endif
           @endforeach

         
         </select>
        </div>
       </div>
</div>
        </div
        
        <!--// Department  and designation -->




        <div class="col-md-12" style="padding-left: 26px; padding-right:26px;">
<div class="row">
         <div class="col-md-6">
          <div class="form-group">
           <label for="title" >First Guarantor Division</label>
             <select class="form-control input-lg" name="division" id="division">
              <option>Select</option>
              @foreach($divisions as $list)
              @if($list->ID == $guaran->branch)
             <option value="{{$list->ID}}" selected>{{$list->division}}</option>
             @else
             <option value="{{$list->ID}}">{{$list->division}}</option>
             @endif
             @endforeach
            </select>
         </div>
        </div>
@php

$divMembers = DB::table('tblmembers')->where('branch','=',$guaran->branch)->get();

@endphp
        <div class="col-md-6">
         <div class="form-group">
          <label for="title" >Select First Guarantor</label>
          <select class="form-control input-lg" name="guarantor" id="guarantor">
         
@foreach($divMembers as $l)
 @if($l->regNo == $myrequest->gaurantor)
           <option value="{{$myrequest->gaurantor}}" selected>{{$guaran->first_name}} {{$guaran->middle_name}} {{$guaran->last_name}}</option>
@else
<option value="{{$l->regNo}}">{{$l->first_name}} {{$l->middle_name}} {{$l->last_name}}</option>
@endif
@endforeach

         </select>
        </div>
       </div>
</div>
        </div>


        <div class="col-md-12" style="padding-left: 26px; padding-right:26px;">
     <div class="row">
         <div class="col-md-6">
          <div class="form-group">
           <label for="title" >Second Guarantor Division</label>
             <select class="form-control input-lg" name="division2" id="division2">
              <option>Select</option>
             @foreach($divisions as $list)
              @if($list->ID == $guaran2->branch)
             <option value="{{$list->ID}}" selected>{{$list->division}}</option>
             @else
             <option value="{{$list->ID}}">{{$list->division}}</option>
             @endif
             @endforeach
            </select>
         </div>
        </div>

        <div class="col-md-6">
         <div class="form-group">
          <label for="title" >Select Second Guarantor</label>
          <select class="form-control input-lg" name="guarantor2" id="guarantor2">
           @foreach($divMembers as $l)
 @if($l->regNo == $myrequest->guarantor2)
           <option value="{{$myrequest->guarantor2}}">{{$guaran2->first_name}} {{$guaran2->middle_name}} {{$guaran2->last_name}}</option>

@else
<option value="{{$l->regNo}}">{{$l->first_name}} {{$l->middle_name}} {{$l->last_name}}</option>
@endif
@endforeach
         </select>
        </div>
        </div>
</div>
        </div>


        <div class="col-md-12" style="padding-left: 26px; padding-right:26px;">
<div class="row">
         <div class="col-md-4">
          <div class="form-group">
           <label for="title" >Number of Month Payable</label>
             <select class="form-control input-lg" name="months" id="months">
              <option>Select</option>
              @for($i=1;$i<=36;$i++)
              @if($i==$myrequest->period)
              <option selected>{{$i}}</option>
              @else
              <option>{{$i}}</option>
              @endif
              @endfor
            </select>
         </div>
        </div>

        <div class="col-md-4">
         <div class="form-group">
          <label for="title">Loan Monthly Repayment</label>
          <input type="text" name="loanMonthlyRepay" class="form-control input-lg" id="loanMonthly" value="{{$myrequest->loan_repay}}" readonly required>
        </div>
       </div>

       <div class="col-md-4">
        <div class="form-group">
         <label for="title" >Interest Monthly Repayment</label>
         <input type="text" name="interestMonthly" class="form-control input-lg" id="interestMonthly" value="{{$myrequest->interest_repay}}" readonly required >
       </div>
      </div>
</div>
        </div>

        <div class="col-md-12" style="padding-left: 26px; padding-right:26px;">
<div class="row">
          <div class="col-md-6">
           <div class="form-group">
            <label for="title" >Total Monthly Repayment</label>
            <input type="text" name="totalmonthly" class="form-control input-lg" id="totalrepay" value="{{$totalMonthly_repay}}" readonly required>
          </div>
         </div>

         <div class="col-md-6">
          <div class="form-group">
           <label for="title" >MonthlyContribution + Total Monthly Repayment</label>
           <input type="text" name="total" class="form-control input-lg" id="total" disabled readonly value="{{$total_monthly}}">
         </div>
        </div>
</div>
        </div>


       <div class="col-md-2" style="padding-left: 26px; padding-right:26px;">
        <div class="form-group">
          <label for="title"></label>

            <input type="submit" class="btn btn-primary" placeholder="Title" value="Submit" name="submit">

        </div>
        </div>
      </form>


 </div>
</div>


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
  var contribution = $('#contribution').val();
  
$.ajax({
  url: murl +'/calculate/loan-interest',
  type: "post",
  data: {'amt': amount,'contribution':contribution, '_token': $('input[name=_token]').val()},
  success: function(data){
  console.log(data.title);
   $('#interest').val(data.total_interest);
$('#loanMonthly').val(data.monthly_loan);
       $('#interestMonthly').val(data.monthly_interest);
       $('#totalrepay').val(data.monthly_repay);
       $('#total').val(data.total);
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

  $('#division2').change( function(){
    //$('#processing').text('Processing. Please wait...');
    $.ajax({
      url: murl +'/get-members',
      type: "post",
      data: {'division': $('#division2').val(), '_token': $('input[name=_token]').val()},

      success: function(data){

    $('#guarantor2').empty();
        $('#guarantor2').append( '<option value="">Select Guarantor</option>' );
        $.each(data, function(index, obj){
        $('#guarantor2').append( '<option value="'+obj.regNo+'">'+obj.last_name+' '+obj.middle_name+' '+obj.first_name+'</option>' );
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

(function () {

  $('#amount').change( function(){

    $('#loanMonthly').val("");
    $('#interestMonthly').val("");
    $('#totalrepay').val("");
    $('#total').val("");
$('#months').append( '<option value="" selected>Select</option>' );
  });}) ();

</script>




@stop
