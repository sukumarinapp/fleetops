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
<div class="card card-success">
  <div class="card-header">
   <h5 class="title" style="text-align:center;">Vehicle Rental Customer</h5>

 </div>
 <div class="card-body">
  <input type="hidden" id="VNO" name="VNO" value="">

<div class="row">
  <div class="col-md-12 text-center">
    <a href="../../uploads/VCC/{{ $VCC }}" target="_blank" class="btn btn-info" >View Contract</a>
  </div>
</div>

              <div class="form-group row">
                    <label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Input Acceptence Code</label>
                    <div class="col-sm-8">
                      <input required="required" type="text" maxlength="6" class="form-control number" name="" id="" >
                    </div>
                  </div>
                </div>

<nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">    
<a href="{{ url('tasks') }}/{{ Session::get('VNO') }}" class="btn btn-info">Back</a>&nbsp;
<input required="required" class="btn btn-info"
            type="submit" id="save" name="submit" value="Accept"/>&nbsp;  
  <a href="{{ route('driver') }}" class="btn btn-info">Logout</a>
</nav>
</div>
</div>
</div>

@endsection