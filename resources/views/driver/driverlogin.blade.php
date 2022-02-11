@extends('layouts.driver')
@section('content')
<div class="container" >
  <div class="card card-default">
    <div class="card-body">
      <form method="post" action="{{ route('validate_login') }}">
        @csrf
      <div class="row justify-content-center">
        <div class="col-md-12 text-center">
          <a href="#" class="navbar-brand">
                <img src="{{ URL::to('/') }}/images/fleetopslogo.png" alt="AdminLTE Logo">
            </a>
          <h3 style="color: lightgray">My Account</h3>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-12">
          <p>Input the vehicle registration number and your account access password. Please be
           clear about your entries. Thank you.</p>
        </div> 
      </div>
       <div class="row justify-content-center">
        <div class="col-md-12">
          <p class="text-danger">{{ $error_msg }}</p>
        </div> 
      </div>
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="form-group row">
             <label for="VNO" class="col-sm-3 col-form-label">Vehicle Reg No:</label>
             <div class="col-sm-9">
              <input value="{{ $VNO }}" required="required" type="text" class="form-control" name="VNO" id="VNO" maxlength="15" placeholder="Vehicle Registration No">
              <p>Enter registration number without any space or ‘-’ dash between the letters or numbers. Example for GW 1234-20,input GW123420 or gw123420</p>
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="form-group row">
             <label for="password" class="col-sm-3 col-form-label">Password:</label>
             <div class="col-sm-9">
              <input value="{{ $password }}" required="required" type="password" class="form-control number" name="password" id="passsword" maxlength="10" placeholder="Password">
              <p>Enter your password press ‘continue’. A One-time-pin will be sent to your registered mobile number for access into your account.</p>
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