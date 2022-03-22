<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>@yield('pageTitle')</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{asset('assets/vendors/iconfonts/simple-line-icon/css/simple-line-icons.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendors/css/vendor.bundle.base.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendors/css/vendor.bundle.addons.css')}}">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" />

</head>
<body style="background:#eee;">
<div class="container" style="background:#fff;">
<center>
<br><br>

</center>

<div class="col-12">
<DIV CLASS="row">
<DIV CLASS="col-12">
<br><br>
<p>DATE:.....<b>{{ date('d M,Y') }}</b>..........</p>
</div>
<DIV CLASS="col-6">
<p>DEPT/MINISTRY:............... {{$depart->department}} ....................</P>
</div>
<DIV CLASS="col-6">@php  @endphp
<p>LOCATION: ....<b> {{ $name->division }}</b>..........</P>
</div>
<div CLASS="col-12">
<p>SURNAME:........<b>{{ $name->last_name }}</b>...........</P>
</div>
<div CLASS="col-12">
<p>OTHER NAMES:........<b>{{ $name->first_name }}..{{ $name->middle_name }}</b>.........</P>
</div>
<BR>
<div CLASS="col-12">
@php
$total = $deduction->monthly_contribution + $deduction->loan_repay + $deduction->interest_repay;
//$f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
//$wordtotal = $f->format($total);

//$oldtot = $info->old_loan + $info->old_mc + $info->old_interest;
//$oldtotw = $f->format($oldtot);
@endphp
<p>A member of the above-named Society request/authorized that a deduction of <b>....N{{ number_format($total) }}</b>......... per month from my salary/wages/pension, until further notice, be made and paid to the Treasurer of the Society.</P>
</div>
<BR>
<div CLASS="col-12">
<p>Present amount authorized <b>N.....{{ number_format($total) }}.......(<span id="amount1"></span> )....</b>with effect from ...<b>{{ date('d M, Y', $depart->approved_date ) }}</b>....</P>
</div>
<BR>
<div CLASS="col-12">
<!--<p>Previous amount authorized ......<b>Namount......(<span id="amount2"></span>)... </b>...</P>-->
</div>
<DIV CLASS="col-6">

<b> {{$name->last_name}} {{$name->first_name}} {{$name->middle_name}}</b> <br>
Signauture
</div>
<DIV CLASS="col-6">
<b> {{$desig->designation}} </b> <br>
Designation/GL
</div>
<DIV CLASS="col-6"><br>
............................................................<br>
Designtion of Officere by whom salary / pension is paid<br>
ADDRESS : ..................................................<br>
LOCATION: ..................................................
</div>
</div>
</DIV>
<br><br>
<button class="btn btn-sm btn-primary" onclick="return printSlip({{ $name->regNo }})">Print</button>&nbsp
<a href="/edit-contrib-approve" class="btn btn-sm btn-info">Go back</a>
<br><br>
<script type="text/javascript" src="{{ asset('number_to_word.js') }}"></script>
<script>
var amount1 = '<?php echo number_format($total) ?>';
var amount2 = '';
word1 = toWords(amount1).toUpperCase();
word2 = toWords(amount2).toUpperCase();
document.getElementById('amount1').innerText = word1;
document.getElementById('amount2').innerText = word2;
function printSlip(id)
{
        return window.open('/printslip/'+id,'','width=842,height=595,left=0,top=0,resizable=yes,menubar=no,location=no,status=yes,scrollbars=yes');
    }
console.log(amount1)
console.log(amount2)
</script>
</body>
</html>