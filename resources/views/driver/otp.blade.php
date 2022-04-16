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
      <div class="row justify-content-center">
        <div class="col-md-12">
          <p class="text-danger">{{ $error_msg }}</p>
        </div> 
      </div>
      <input type="hidden" id="VNO" name="VNO" value="{{ Session::get('VNO') }}">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="form-group row">
             <label for="VNO" class="col-sm-3 col-form-label">One-Time-Pin (OTP):</label>
             <div class="col-sm-9">
              <input required="required" type="text" class="form-control number" name="OTP" id="OTP" maxlength="4" placeholder="OTP">
              <p>Enter the OTP sent to your registered mobile number.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group row">
                <div class="col-sm-9">
                  <p id="remsg" class="text-success text-bold"></p>
          <a href="#" onclick="resend_otp()" >Re-Send OTP</a>
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

@push('page_scripts')
<script>
  function resend_otp(){
    var CSRF_TOKEN = $("input[name=_token]").val();
    $.ajax({
      type: "post",
      url: "/resend_otp",
      data: {_token: CSRF_TOKEN },
      dataType: 'JSON',
      success: function(response) {
        alert("OTP re-sent successfully");
      },
      error: function (jqXHR, exception) {
        console.log(exception);
      }
    });
  }

</script>
@endpush