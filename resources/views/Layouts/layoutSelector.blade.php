@if (Auth::user()) 
  @if(Session::get('roleName') == "admin")
      @include('Layouts.adminLayout')
  @else
      @include('Layouts.layout')
  @endif
@else
      @include('Layouts.layout')
@endif