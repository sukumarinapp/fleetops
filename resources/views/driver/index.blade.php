@extends('layouts.driver')
@section('content')
<div class="container" >
  <div class="row justify-content-center">
  <a href="#" class="navbar-brand">
                <img src="{{ URL::to('/') }}/images/fleetopslogo.png" alt="AdminLTE Logo">
            </a>
          </div>
  <div style="padding: 50px; height: 200px;"></div>
  <div class="row justify-content-center">
    <div class="col-md-12 text-center">

      <h4>Menu</h4>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-12">
        @if ($time["current_time"] > .15)
          <a href="{{ route('drivervno') }}" type="button" class="btn btn-block btn-primary btn-lg text-center">Make Payment</a>
        @endif
     </div>
     <div class="col-md-12" style="padding-top:10px;">
          <a href="{{ route('driverlogin') }}" type="button" class="btn btn-block btn-primary btn-lg text-center">Account Log In</a>
      </div>
    </div>
  <nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">      
      Powered by Fleetops
  </nav>
</div>
@endsection