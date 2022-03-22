@extends('Layouts.layoutSelector')

<style>
.bond{
  padding: 5px 10px;
}
.bond p
{
  font-size:17px;
  line-height: 25px;
}
.bond ul{
  list-style: lower-alpha;
  font-size:17px;

}
.sig{
font-size:17px;
margin-bottom:10px;
}
.box, .box-default, .box-header, .box-default .box-header.with-border
{
  border: none;
  padding: 0px;
  margin:0px;
}
.two-col
{
  width: 50%;
  float:left;
}
body
{
  padding: 0px;
  margin:0px;
}
</style>

@section('content')

<div class="">
  <div class="container hidden-print">
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

<div class="hidden-print" style="margin-top:150px;">
  <div class="container">
    <h4 class="text-center"></h4>
    <h5 class="text-center"></h5>
    <h6 class="text-center"></h6>
    <h5 class="text-center" style="margin-top:15px;">LOAN BOND FORM</h5>
    <div class="bond">
      <p>AGREEMENT made this <b>{{date("jS", strtotime($loan->date_updated))}} </b> day
         of <b>{{date("F", strtotime($loan->date_updated))}}</b> <b>{{date("Y", strtotime($loan->date_updated))}}</b> between the <b></b>
  Multi-purpose Cooperative society Ltd. (Hereinafter called the Lender) on the one part and Mr <b>{{$loan->first_name}}
   {{$loan->middle_name}} {{$loan->last_name}}</b>
  from <b>{{$loan->division}}</b> Division. (Hereinafter called the Borrower) on the
   other part requires the sum of {{$loan->amount}} N : 00 k for the purpose
    of {{$loan->purpose}} and wheras the Borrower has applied to
     the Lender for the said sum of N <b>{{$loan->amount}}</b> for the purpose aforesaid
     5  Where the Borrower failed to pay the outstanding before leaving the service, the two guarantors will be called
  which the Lender has agreed to lend upon having the repayment thereof together with interest
   theron, secured in the manner hereinafter appearing.
      </p>
    <p>
      Now this AGREEMENT witness:-
    </p>
    <p>
  1. In pursuance of thr said agreement and consideration of the sum of N <b>{{$loan->amount}}</b> now paid by the
    <b></b> Multi-purpose Cooperative society Ltd., to the Borrower (receipt whereof the
    Borrower hereby acknowledges) the Borrower covenants with the Lender as follows:-
    <ul>

      <li>The Borrower will repay the sum of N {{$loan->amount + ($loan->interest_repay * $loan->period)}} with interest thereon at the rate of <b>{{$loan->loan_rate}}%</b>
        from the the hereof over a period of {{$loan->period}} months in equal and consecutive monthly installments of N <b>{{$loan->loan_repay + $loan->interest_repay}}</b>
        the first installment due on the .......... day of ................... 20 ......
      </li>
      <li>During the the continuance of this agreement the Borrower shall pay cash regularly each month the sum of N <b>{{$loan->loan_repay + $loan->interest_repay}}</b>
      to be paid over to the <b></b> Multi-purpose Cooperative society Ltd., the Lender.</li>
    </ul>
    </p>

    <p>
   2. If the Borrower is expelled from membership of the society the whole outstanding principal and interest shall
   become payable forthwith.
    </p>
    <p>
   3. The Borrower may terminate this agreement at anytime by paying to the society the amount of principal and
   interest outstanding in respect of the said loan.
    </p>
    <p>
   4. No neglect, delay or indulgence on the part of the society in enforcing any of the terms or conditions of this
   agreement of the Bye-laws of the society shall prejudice the strict right of the Lender in regard to loan.

    </p>
    <p>
   upon to pay the amount outstanding. In addition to valid guarantors, the Borrower would be required to autocomplete
   claim certificate in appendix XI.
    </p>
    <p>
   <h4 class="text-center"> SOCIETY OFFICERS</h4>
   <div class="" style="width:100%;float:left;">
   <div class="two-col sig">
     <p>
  ...................................<br/>
  Borrower's Signature <br/>
  Account Details ........................................ <br/>
  TEL: ...................................................
  </p>
   </div>
   <div class="two-col sig">
  President .............................................. <br/><br/>
  Secretary ..............................................
   </div>
  </div>


  <!--Guarantors -->
  <div class="">
    <h3>Guarantors:-</h3>
  <div class="two-col sig">
  1. Name .........................
  </div>
  <div class="two-col sig">
  Signature ........................
  </div>

  <div class="two-col sig">
  2. Name .........................
  </div>
  <div class="two-col sig">
  Signature ........................
  </div>
  </div>




    </p>
    </div>


</div>



</div>
</div>
@endsection
