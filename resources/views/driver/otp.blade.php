@extends('layouts.driver')
@section('content')
<div class="container" >
  <div class="card card-default">
    <div class="card-body">
      <form method="post" action="{{ route('validate_otp') }}">
        @csrf
      <div class="row justify-content-center">
        <div class="col-md-12 text-center">
          <a href="#" class="navbar-brand">
                <img src="{{ URL::to('/') }}/images/fleetopslogo.png" alt="AdminLTE Logo">
            </a>
          <h3 style="color: lightgray">My Account</h3>
        </div>
      </div>
      <!-- <div class="row justify-content-center">
        <div class="col-md-12">
          <p>Input the vehicle registration number and your account access password. Please be
           clear about your entries. Thank you.</p>
        </div> 
      </div> -->

      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="form-group row">
             <label for="VNO" class="col-sm-3 col-form-label">One-Time-Pin (OTP):</label>
             <div class="col-sm-9">
              <input required="required" type="text" class="form-control" name="VNO" id="VNO" maxlength="15" placeholder="OTP">
              <p>Enter the OTP sent to your registered mobile number.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group row">
                <div class="col-sm-9">
          <a href="{{ route('driverlogin') }}" type="button" class="btn btn-primary btn-sm text-center">Re-Send OTP</a>
              <p>Did not receive previous OTP</p>
            </div>
          </div>
          </div>
        </div>
      </div>

      <nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">      
          <input required="required" class="btn btn-info"
                type="submit" id="save" name="submit" value="Continue"/>&nbsp;
          <a href="{{ route('driver') }}" class="btn btn-info">Cancel</a>
      </nav>
    </form>
    </div>
  </div>
</div>
@endsection