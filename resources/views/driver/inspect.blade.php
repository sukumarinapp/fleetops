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

    <h5 class="title" style="text-align:center;">Inspection Completed</h5>

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
          <a href="#" target="_blank" class="btn btn-info" >View Inspection checklist</a>
        </div>
      </div><br>

      <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Into</label>
        <div class="col-sm-8">
          {{ $DNM }}
        </div>
      </div>

      <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red">*</span>Input Acceptence Code</label>
        <div class="col-sm-4">
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