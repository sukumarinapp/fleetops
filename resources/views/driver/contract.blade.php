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
  <div class="col-md-12">
    <embed src="http://sub.fleetopsgh.com/uploads/VCC/{{ $VCC }}" width="800" height="600"  type="application/pdf">
  </div>
</div>

 <div class="row justify-content-center">
   
 </div>
<nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">    
<a href="{{ url('tasks') }}/{{ Session::get('VNO') }}" class="btn btn-info">Back</a>&nbsp;  
  <a href="{{ route('driver') }}" class="btn btn-info">Logout</a>
</nav>
</div>
</div>
</div>

@endsection