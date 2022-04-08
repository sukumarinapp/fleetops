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
   <h5 class="title" style="text-align:center;">Service Completed</h5>
 </div>

 <div class="card-body">
  <form onsubmit="return validate_all(event);" action="{{ route('saveservicedriver') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
    @csrf
    <div class="row">
     <div class="col-md-6">
      <div class="form-group row">
        <label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Into</label>
        <div class="col-sm-8">
          {{ $DNM }}
        </div>
      </div>
      <div class="form-group row">
        <label for="SER" class="col-sm-4 col-form-label"><span style="color:red"></span>Upload Document (Optional)</label>
        <div class="col-sm-8">
          <input accept="application/pdf,image/png, image/jpeg" name="SER" type="file" id="SER">
        </div>
      </div>
      <div class="form-group row">
        <label for="current_mileage" class="col-sm-4 col-form-label"><span style="color:red">*</span>Current Mileage</label>
        <div class="col-sm-4">
          <input required="required" type="text" maxlength="8" class="number form-control" name="current_mileage" id="current_mileage" >
        </div>
      </div>
    </div>
  </div>
<nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">  
  
  <a href="{{ url('tasks') }}" class="btn btn-info">Back</a>&nbsp;
  <input required="required" class="btn btn-info"
  type="submit" id="save" name="submit" value="Submit"/>&nbsp;
  <a href="{{ route('driver') }}" class="btn btn-info">Logout</a>
</nav>
</form>
</div>
</div>

@endsection

@section('third_party_scripts')
<script>
function validate_all(e){
    var selection = document.getElementById('SER');
    for (var i=0; i<selection.files.length; i++) {
        if(selection.files[i].size > 5000000){
          alert('Uploaded document size can be a maximum of 5MB');
            return false;
        }
    } 
  }
</script>
@endsection