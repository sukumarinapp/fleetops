@extends('layouts.driver')
@section('content')
<div class="container" >
 <div class="row justify-content-center">
  <div class="col-md-12 text-center">
    <a href="#" class="navbar-brand">
      <img src="{{ URL::to('/') }}/images/fleetopslogo.png" alt="AdminLTE Logo">
    </a>
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
    <input type="hidden" id="VNO" name="VNO" value="">
    <form action="{{ route('acceptcontract') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
      @csrf
      <div class="row">

        <div class="col-md-12 text-center">
          <a onclick="acceptance_code();" class="btn btn-info" style="color:white" >Read Contract</a>
        </div>
      </div><br>

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
        <label for="" class="col-sm-4 col-form-label"><span style="color:red">*</span>Input Acceptence Code</label>
        <div class="col-sm-2">
          <input required="required" type="text" maxlength="4" class="form-control number" name="acceptance_code" id="acceptance_code" >
        </div>
      </div>
    </div>

    <nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">    
      <a href="{{ url('tasks') }}" class="btn btn-info">Back</a>&nbsp;
      <input required="required" class="btn btn-info"
      type="submit" id="save" name="submit" value="Accept"/>&nbsp;  
      <a href="{{ route('driver') }}" class="btn btn-info">Logout</a>
    </nav>
  </form>
</div>
</div>
</div>

@endsection
@push('page_scripts')
<script>
var acceptance_code_url = "{{ url('acceptance_code') }}";
function acceptance_code(){
  var url =  acceptance_code_url;
  $.ajax({
      type: "get",
      url: url,
      success: function(response) {
        window.open  ('../../uploads/VCC/{{ $file_name }}', '_blank');
      },
      error: function (jqXHR, exception) {
        console.log(exception);
      }
  });
}
</script>