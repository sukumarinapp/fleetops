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

   <h5 class="title" style="text-align:center;">Ride Hailing Driver</h5>
  

 </div>
 <div class="card-body">
  <div class="row justify-content-center">
    <div class="col-md-12">
     <label class="col-form-label">Account Name   : </label>
   </div>
   <div class="col-md-12">
     <label class="col-form-label">Vehicle Reg No : </label>
   </div>
   <div class="col-md-12">
     <label class="col-form-label">Reg Phone Number : </label>
   </div>
 </div>
 <hr>
 <div class="row">
  <div class="col-md-12">
    <a href=""> <i style="float:right;margin-top: 80px;" class="fa fa-download"></i></a>
    <div class="row justify-content-center">
      <h5 style="color: lightgray">Tasks</h5>
      <div class="col-md-12">
       <label class="col-form-label">Licence Renewal   : </label>
     </div>
     <div class="col-md-12">
       <label class="col-form-label">Expiry Date  : </label> 05-03-2022 
       <span class="text-danger">(expired)</span>
     </div> 
     <div class="col-md-12">
      <p>Please take a snapshot of renewed license</p>
    </div>


  </div>
</div>
</div>
<hr><div class="row">
  <div class="col-md-12">
    <a href=""> <i style="float:right;margin-top: 80px;" class="fa fa-download"></i></a>
    <div class="row justify-content-center">
     <div class="col-md-12">
      <label class="col-form-label">Contract Renewal</label>
     </div>
     <div class="col-md-12">
       <label class="col-form-label">Expiry Date  : </label>
     </div> 
     <div class="col-md-12">
      <p>Please read contract fully. Confirm acceptance by
        inputting code that would be sent to you via SMS
      on your registered phone number.</p>
    </div>


  </div>
</div>
</div>
<hr><div class="row">
  <div class="col-md-12">
    <a href=""> <i style="float:right;margin-top: 80px;" class="fa fa-download"></i></a>
   <div class="row justify-content-center">
     <div class="col-md-12">
       <label class="col-form-label">Vehicle Servicing</label>
     </div>
     <div class="col-md-12">
       <label class="col-form-label">Expiry Date  : </label>
     </div>
     <div class="col-md-12">
       <label class="col-form-label">Venue  : </label>
     </div> 
     <div class="col-md-12">
      <p>Click icon when servicing is complete</p>
    </div>


  </div>
</div>
</div>
<hr><div class="row">
  <div class="col-md-12">
    <a href=""> <i style="float:right;margin-top: 80px;" class="fa fa-download"></i></a>
   <div class="row justify-content-center">
     <div class="col-md-12">
       <label class="col-form-label">Vehicle Inspection</label>
     </div>
     <div class="col-md-12">
       <label class="col-form-label">Expiry Date  : </label>
     </div>
     <div class="col-md-12">
       <label class="col-form-label">Venue  : </label>
     </div> 
     <div class="col-md-12">
      <p>Click icon when Inspection is complete</p>
    </div>


  </div>
</div>
</div>
<hr>
<nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">      
  <a href="{{ route('driver') }}" class="btn btn-info">Logout</a>
</nav>
</div>
</div>
</div>

@endsection