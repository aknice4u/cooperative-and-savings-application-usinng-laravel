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

<div class="container-fluid page-body-wrapper" style="">
      <div class="main-panel" style="">
        <div class="content-wrapper" style="padding-left:0px;padding-right:0px;">
          <div class="rows">

<div class="col-md-12 col-xs-12 col-ms-12 grid-margin grid-margin-md-0 stretch-card" style="padding-left:0px;padding-right:0px;">
              <div class="card" style="padding-left:0px;padding-right:0px;">
                <div class="card-body" style="padding-left:0px;padding-right:0px;">
<h2 class="text-center" style="margin-bottom:20px;padding-bottom:20px;">LOAN REQUEST FORM</h2>
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


<div class="row">
<div class="col-md-12">
  
<form class="form-horizontal" action="{{url('/loan-request/create')}}" method="post" >

      {{ csrf_field() }}
      <div class="col-md-12" style="padding-left: 26px; padding-right:26px;">
<div class="row">
        <div class="col-sm-4" style="">
         <div class="form-group">
          <label for="title" >First Name</label>
          <input type="hidden" name="regNo" value="{{$member->fileNo}}" >
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
  </div><!-- row-->

        </div>

        <div class="col-md-12" style="padding-left: 26px; padding-right:26px;">
<div class="row">
          <div class="col-md-4">
        <div class="form-group" >
          <label for="title" >Monthly Saving</label>
          <input type="text" name="contribution" class="form-control" id="contribution" readonly required value="{{$member->monthly_contribution}}">
        </div>
      </div>

      <div class="col-md-4">
       <div class="form-group">
        <label for="title" >Loan Amount</label>
          <input type="text" name="amount" class="form-control" id="amount" required value="{{old('amount')}}">
      </div>
     </div>

     <div class="col-md-4">
      <div class="form-group">
       <label for="title" >Loan Interest</label>
         <input type="text" name="interest" class="form-control" id="interest" readonly required value="{{old('interest')}}">
     </div>
    </div>
</div>
        </div>




        <div class="col-md-12" style="padding-left: 26px; padding-right:26px;">
<div class="row">
          <div class="col-md-4">
           <div class="form-group">
            <label for="title" >Purpose</label>
            <textarea class="form-control" name="purpose" required >{{old('purpose')}}</textarea>
          </div>
         </div>

         <div class="col-md-4">
          <div class="form-group">
           <label for="title" >Bank</label>
             <select class="form-control input-lg" name="bank" required>
               <option>Select Bank</option>
               @foreach($banks as $list)
@if($list->ID == $member->bankid)
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
          <input type="text" name="accountNumber" class="form-control input-lg" id="acctNo" required value="{{$member->myAcctno}}">
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
             <option value="{{$list->Id}}">{{$list->department}}</option>
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
              <option value="{{$list->Id}}" @if(old('designation') == $list->Id) selected @endif>{{$list->designation}}</option>
           @endforeach

         
         </select>
        </div>
       </div>
</div>
        </div
        
        <!-- Department  and designation -->




        <div class="col-md-12" style="padding-left: 26px; padding-right:26px;">
 <div class="row">
         <div class="col-md-6">
          <div class="form-group">
           <label for="title" >First Guarantor Division</label>
             <select class="form-control input-lg" name="division" id="division">
              <option >Select</option>
              @foreach($divisions as $list)
             <option value="{{$list->ID}}">{{$list->division}}</option>
             @endforeach
            </select>
         </div>
        </div>

        <div class="col-md-6">
         <div class="form-group">
          <label for="title" >Select First Guarantor</label>
          <select class="form-control input-lg" name="guarantor" id="guarantor">
           <option value="">Select</option>
           @if($guaran != '')
           @foreach ($guaran as $list)
              <option value="{{$list->regNo}}" @if(old('guarantor') == $list->regNo) selected @endif>{{$list->first_name}} {{$list->middle_name}} {{$list->last_name}}</option>
           @endforeach

           @endif
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
             <option value="{{$list->ID}}" @if(old('division2') == $list->ID) selected @endif>{{$list->division}}</option>
             @endforeach
            </select>
         </div>
        </div>

        <div class="col-md-6">
         <div class="form-group">
          <label for="title" >Select Second Guarantor</label>
          <select class="form-control input-lg" name="guarantor2" id="guarantor2">
           <option value="">Select</option>
            @if($guaran2 != '')
           @foreach ($guaran2 as $list)
              <option value="{{$list->regNo}}" @if(old('guarantor2') == $list->regNo) selected @endif>{{$list->first_name}} {{$list->middle_name}} {{$list->last_name}}</option>
           @endforeach

           @endif
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
              <option>12</option>
              @for($i=1;$i<=36;$i++)
              <option>{{$i}}</option>
              @endfor
            </select>
         </div>
        </div>

        <div class="col-md-4">
         <div class="form-group">
          <label for="title">Loan Monthly Repayment</label>
          <input type="text" name="loanMonthlyRepay" class="form-control input-lg" id="loanMonthly" readonly required>
        </div>
       </div>

       <div class="col-md-4">
        <div class="form-group">
         <label for="title" >Interest Monthly Repayment</label>
         <input type="text" name="interestMonthly" class="form-control input-lg" id="interestMonthly" readonly required >
       </div>
      </div>
</div>
        </div>

        <div class="col-md-12" style="padding-left: 26px; padding-right:26px;">
<div class="row">
          <div class="col-md-6">
           <div class="form-group">
            <label for="title" >Total Monthly Repayment</label>
            <input type="text" name="totalmonthly" class="form-control input-lg" id="totalrepay" readonly required>
          </div>
         </div>

         <div class="col-md-6">
          <div class="form-group">
           <label for="title" >MonthlyContribution + Total Monthly Repayment</label>
           <input type="text" name="total" class="form-control input-lg" id="total" disabled readonly value="{{old('total')}}">
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
  url: murl +'/calculate/loan-interest-rate',
  type: "post",
  data: {'amt': amount,'contribution':contribution, '_token': $('input[name=_token]').val()},
  success: function(data){
  console.log(data);
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
      url: murl +'/get-members/detail',
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
      url: murl +'/get-members/detail',
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
      url: murl +'/calculate/monthly-repayment',
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


@stop
