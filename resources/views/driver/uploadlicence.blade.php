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
   <h5 class="title" style="text-align:center;">Upload License</h5>
 </div>

 <div class="card-body">
  
  <input type="hidden" id="VNO" name="VNO" value="">
  <form action="{{ route('savelicence') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
    @csrf
    <div class="row">
     <div class="col col-md-6">
       <div class="form-group row">
                    <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Into</label>
                    <div class="col-sm-8">
                      {{ $DNM }}
                    </div>
                  </div>
                 <div class="form-group row">
                    <label for="DLD" class="col-md-4 col-form-label"><span style="color:red">*</span>Licence Front</label>
                    <div class="col-md-8">
                      <input required="required" accept="image/png, image/jpeg" name="DLD" type="file" id="DLD">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="DLD2" class="col-md-4 col-form-label"><span style="color:red">*</span>Licence Back</label>
                    <div class="col-md-8">
                      <input required="required" accept="image/png, image/jpeg" name="DLD2" type="file" id="DLD2">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="LEX" class="col-md-4 col-form-label"><span style="color:red">*</span>License Expiry Date</label>
                    <div class="col-md-8">
                      <input required="required" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" onkeydown="return false" type="date" class="form-control" name="LEX" id="LEX" >
                    </div>
                  </div>
                </div>
</div>
<nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">  
    
    <a href="{{ url('tasks') }}" class="btn btn-info">Back</a>&nbsp;
    <input class="btn btn-info"
    type="submit" id="save" name="submit" value="Submit"/>&nbsp;
    <a href="{{ route('driver') }}" class="btn btn-info">Logout</a>
  </nav>
</form>

</div>
</div>

@endsection