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
   @if($VBM == "Hire Purchase")
   <h5 class="title" style="text-align:center;">Hire Purchase Customer</h5>
   @elseif($VBM == "Rental")
   <h5 class="title" style="text-align:center;">Vehicle Rental Customer</h5>
   @else
   <h5 class="title" style="text-align:center;">Ride Hailing Driver</h5>
   @endif

 </div>
 <div class="card-body">
   <div class="form-group row">
    <label  class="col-6 col-form-label">Status</label>
    <label  class="col-1 col-form-label">:</label>
    <p  class="col-5 col-form-label">Customer</p>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-6 col-form-label">Business</label>
    <label for="example-text-input" class="col-1 col-form-label">:</label>
    <p for="example-text-input" class="col-5 col-form-label">Hire-Purchase</p>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-6 col-form-label">Vehicle No</label>
    <label for="example-text-input" class="col-1 col-form-label">:</label>
    <p for="example-text-input" class="col-5 col-form-label">Hire-Purchase</p>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-6 col-form-label">Purchase Price</label>
    <label for="example-text-input" class="col-1 col-form-label">:</label>
    <p for="example-text-input" class="col-5 col-form-label">Hire-Purchase</p>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-6 col-form-label">Down Payment</label>
    <label for="example-text-input" class="col-1 col-form-label">:</label>
    <p for="example-text-input" class="col-5 col-form-label">Hire-Purchase</p>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-6 col-form-label">Security Deposit (Refundable):
    </label>
    <label for="example-text-input" class="col-1 col-form-label">:</label>
    <p for="example-text-input" class="col-5 col-form-label">Hire-Purchase</p>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-6 col-form-label">Term</label>
    <label for="example-text-input" class="col-1 col-form-label">:</label>
    <p for="example-text-input" class="col-5 col-form-label">Hire-Purchase</p>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-6 col-form-label">Payment (Amount)</label>
    <label for="example-text-input" class="col-1 col-form-label">:</label>
    <p for="example-text-input" class="col-5 col-form-label">Hire-Purchase</p>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-6 col-form-label">Payment Frequency</label>
    <label for="example-text-input" class="col-1 col-form-label">:</label>
    <p for="example-text-input" class="col-5 col-form-label">Hire-Purchase</p>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-6 col-form-label">Contract End Date</label>
    <label for="example-text-input" class="col-1 col-form-label">:</label>
    <p for="example-text-input" class="col-5 col-form-label">Hire-Purchase</p>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-6 col-form-label">First Payment (Date)</label>
    <label for="example-text-input" class="col-1 col-form-label">:</label>
    <p for="example-text-input" class="col-5 col-form-label">Hire-Purchase</p>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-6 col-form-label">Last Payment (Date)</label>
    <label for="example-text-input" class="col-1 col-form-label">:</label>
    <p for="example-text-input" class="col-5 col-form-label">Hire-Purchase</p>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-6 col-form-label">No of Installments</label>
    <label for="example-text-input" class="col-1 col-form-label">:</label>
    <p for="example-text-input" class="col-5 col-form-label">Hire-Purchase</p>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-6 col-form-label">Default Penalty Applicable</label>
    <label for="example-text-input" class="col-1 col-form-label">:</label>
    <p for="example-text-input" class="col-5 col-form-label">Hire-Purchase</p>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-6 col-form-label">No of Defaults Allowed</label>
    <label for="example-text-input" class="col-1 col-form-label">:</label>
    <p for="example-text-input" class="col-5 col-form-label">Hire-Purchase</p>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-6 col-form-label">Default Penalty Amount</label>
    <label for="example-text-input" class="col-1 col-form-label">:</label>
    <p for="example-text-input" class="col-5 col-form-label">Hire-Purchase</p>
  </div>
  <div class="form-group row">
    <label for="example-text-input" class="col-6 col-form-label">Default Penalty Payment Frequency</label>
    <label for="example-text-input" class="col-1 col-form-label">:</label>
    <p for="example-text-input" class="col-5 col-form-label">Hire-Purchase</p>
  </div>

  <nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">      
    <a href="{{ route('driver') }}" class="btn btn-info">Logout</a>
  </nav>
</div>
</div>
</div>

@endsection