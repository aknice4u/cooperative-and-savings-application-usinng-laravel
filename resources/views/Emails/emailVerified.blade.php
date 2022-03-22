@extends('Layouts.layout')

@section('pageTitle')
  Viradian
@endsection

@section('content')
    <!-- viradian form
    ================================================== -->
    <section class="section_contact" id="section_contact">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            
            <div class="contact__container">
              <div class="row">
                <div class="col-sm-12">
                  

                  <!-- Form -->
                  <form class="contact__container__form form-horizontal" method="post" action="" id="form_sendemail">
                    {{ csrf_field() }}

                    <div class="form-group"><!---->
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

                            @if(session('err'))
                                <div class="alert alert-warning alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong>Not Allowed ! </strong> 
                        {{ session('err') }}
                        </div>                        
                        @endif
                    </div><!---->

                    <!-- Header -->
                    <div class="form-group" align="center">
                        <p>
                            <h3><b style="color: green; text-transform: uppercase;">Email verification was successful</b></h3>
                        </p>
                        <p>
                          <h4 style="color: green">Thank you.</h4>
                        </p>
                        <p>
                          <a href="{{url('/advertiser/create')}}" class="btn btn-success input-lg">
                              START YOUR SERVICE REQUEST
                          </a>
                        </p>
                    </div>

                    <footer class="section_footer" style="margin: 0px; background: #fff; padding: 0px;">
                      
                        <div class="row">
                          <div  align="center" class="col-sm-12">
                            <ul class="footer__social">
                            <li>
                                <a class="twitter" href="{{url('https://twitter.com/Virads3')}}" target="_blank">
                                  <i class="ion-social-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a class="facebook" href="{{url('https://www.facebook.com/Virads-Media')}}" target="_blank">
                                  <i class="ion-social-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a class="youtube" href="{{url('https://www.youtube.com/results?search_query=Viral+Video+Networks')}}" target="_blank">
                                  <i class="ion-social-youtube"></i>
                                </a>
                            </li>
                            <li>
                                <a class="histagram" href="{{url('https://www.instagram.com/viradsmedia/?hl=en')}}" target="_blank">
                                  <i class="icon-social-instagram"><b>H</b></i>
                                </a>
                            </li>
                          </ul>
                          </div>
                        </div> <!-- / .row -->
                     
                    </footer>
                    
                  </form>
                </div>
              </div> <!-- / .row -->
            </div>
          </div>
        </div> <!-- / .row -->
      </div> <!-- / .container -->
    </section>
@stop

@section('scripts')
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
  <script type="text/javascript">
    $('#toggle').click(function () {
      //check if checkbox is checked
      if ($(this).is(':checked')) {
          
          $('#submitForm').removeAttr('disabled'); //enable input
          
      } else {
          $('#submitForm').attr('disabled', true); //disable input
      }
    });
  </script>
@stop