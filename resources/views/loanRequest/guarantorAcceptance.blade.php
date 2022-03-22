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
<h3> Details of the Loan Request</h3>
  <table class="table table-striped">
         <thead>
         <tr>
         <th>SN</th>
         <th>Name</th>
         <th>Loan Amount</th>
         <th>Period Of Payment</th>
         </thead>
         <tbody>
         @php $k= 1; @endphp
         @foreach($myrequest as $list)
  		<tr>
  		<td>{{$k++}}</td>
  		<td>{{$list->first_name}} {{$list->middle_name}} {{$list->last_name}}</td>
  		<td>{{number_format($list->amount,2)}}</td>
  		<td>{{$list->period}}</td>
  		</tr>
  		@endforeach
         </tbody>
         </table>
         <form method="post" action="">
         <input type="hidden" name="code" value="">
         <input type="submit" value="Accept" class="btn btn-success" >
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


@stop
