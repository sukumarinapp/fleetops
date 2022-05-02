@extends('layouts.driver')
@section('content')
<div class="container" >
 <div class="row justify-content-center">
  <div class="col-md-12 text-center">
      <img src="{{ URL::to('/') }}/images/fleetopslogo.png" alt="Logo">
    <h3 style="color: lightgray">My Account</h3>
  </div>
</div>
<div class="card card-primary">
  <div class="card-header">
    <h5 class="title" style="text-align:center;">Agreement, Terms & Conditions</h5>
  </div>
  <div class="card-body">
    @if(session()->has('error'))
    <div class="alert alert-danger alert-dismissable" style="margin: 15px;">
      <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong> {{ Session::get('error') }} </strong>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12 text-center">
         <label>Please read contract to receive Acceptance Code</label> 
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 text-center">
          <a onclick="fn_acceptance_code()" class="btn btn-info" style="color:white" >Read Contract</a>
        </div>
      </div><br>
    <form action="{{ route('acceptcontract') }}" method="post"  class="form-horizontal">
      @csrf
      <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Into</label>
        <div class="col-sm-8">
          {{ $DNM }}
        </div>
      </div>

      <div class="form-group row">
        <p class="col-sm-12 col-form-label">I have read and understood the terms and conditions of this contract (or it has been read and interpreted to you in a language that you understand) and by inputting this acceptance code below I willingly accept it.</p>
     </div>
        <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red">*</span>Input Acceptance Code</label>
        <div class="col-sm-2">
          <input required="required" type="text" maxlength="4" class="form-control number" name="acceptance_code2" id="acceptance_code2" >
        </div>
      </div>
    </div>

    <nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">    
      <a href="{{ url('tasks') }}" class="btn btn-info">Back</a>&nbsp;
      <input required="required" class="btn btn-info"
      type="submit" id="save" name="submit" value="Accept"/>&nbsp;  
      <a href="{{ url('reject_contract') }}" class="btn btn-danger">Reject</a>&nbsp;
      <a href="{{ route('driver') }}" class="btn btn-info">Logout</a>
    </nav>
  </form>
</div>
</div>
</div>
@endsection

@section('third_party_scripts')
<script>
function fn_acceptance_code(){
    //$('#remsg').text('');
    var CSRF_TOKEN = $("input[name=_token]").val();
    $.ajax({
      type: "post",
      url: "/acceptance_code",
      data: {_token: CSRF_TOKEN },
      dataType: 'JSON',
      success: function(response) {
        window.open('../../uploads/driver/{{ $file_name }}', '_blank');
      },
      error: function (jqXHR, exception) {
        console.log(exception);
      }
  });
}
</script>
@endsection