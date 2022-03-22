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
<body  onload="print()">
<div class="container-fluid" style="background:#fff;">
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
<p>DEPT/MINISTRY:..........................................</P>
</div>
<DIV CLASS="col-6">@php $branch = DB::table('tbldivision')->where('ID', $user->branch)->first()->division; @endphp
<p>LOCATION: ....<b>{{ $branch }}</b>..........</P>
</div>
<div CLASS="col-12">
<p>SURNAME:........<b>{{ $user->last_name }}</b>...........</P>
</div>
<div CLASS="col-12">
<p>OTHER NAMES:........<b>{{ $user->first_name }}..{{ $user->middle_name }}</b>.........</P>
</div>
<BR>
<div CLASS="col-12">
@php
$total = $info->new_mc + $info->new_loan + $info->new_interest;
//$f = new \NumberFormatter("en", \NumberFormatter::SPELLOUT);
//$wordtotal = $f->format($total);

$oldtot = $info->old_mc + $info->old_loan + $info->old_interest;
//$oldtotw = $f->format($oldtot);
@endphp
<p>A member of the above-named Society request/authorized that a deduction of N.......<b>{{ $total }}</b>............ per month from my salary/wages/pension, until further notice, be made and paid to the Treasurer of the Society.</P>
</div>
<BR>
<div CLASS="col-12">
<p>Present amount authorized <b>N.....{{ number_format($total) }}.......(<span id="amount1"></span> )....</b>with effect from ...<b>{{ date('d M, Y', $info->date_approved ) }}</b>....</P>
</div>
<BR>
<div CLASS="col-12">
<p>Previous amount authorized ......<b>N{{ number_format($oldtot) }}......(<span id="amount2"></span>)... </b>...</P>
</div>
<DIV CLASS="col-6">
..............................................................<br>
Signauture
</div>
<DIV CLASS="col-6">
.............................................................<br>
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
<script type="text/javascript" src="{{ asset('number_to_word.js') }}"></script>
<script>

var amount1 = '<?php echo number_format($total) ?>';
var amount2 = '<?php echo number_format($oldtot) ?>';
word1 = toWords(amount1).toUpperCase();
word2 = toWords(amount2).toUpperCase();
document.getElementById('amount1').innerText = word1;
document.getElementById('amount2').innerText = word2;

console.log(amount1)
console.log(amount2)
</script>
</body>
</html>