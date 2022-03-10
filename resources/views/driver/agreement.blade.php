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
   <h5 class="title" style="text-align:center;">HIRE-PURCHASE AGREEMENT SUMMARY</h5>
   @elseif($VBM == "Rental")
   <h5 class="title" style="text-align:center;">VEHICLE RENTAL AGREEMENT SUMMARY</h5>
   @else
   <h5 class="title" style="text-align:center;">RIDE-HAILING AGREEMENT SUMMARY</h5>
   @endif

 </div>
 <div class="card-body">
  <input type="hidden" id="VNO" name="VNO" value="{{ $VNO }}">
   @if($VBM == "Hire Purchase")
   <div class="form-group row">
    <label class="col-6 col-form-label">Status</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">Customer</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Business</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">{{ $VBM }}</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Vehicle No</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">{{ $VNO }}</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Purchase Price</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">{{ $PPR }}</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Down Payment</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">{{ $PDP }}</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Security Deposit (Refundable):
    </label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">{{ $SDP }}</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Term</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">N/A</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Payment (Amount)</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">{{ $VAM }}</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Payment Frequency</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">{{ $VPF }}</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Contract End Date</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">{{ $CEX }}</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">First Payment (Date)</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">N/A</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Last Payment (Date)</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">N/A</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">No of Installments</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">N/A</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Default Penalty Applicable</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">{{ $EPD }}</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">No of Defaults Allowed</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">{{ $NOD }}</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Default Penalty Amount</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">{{ $PAM }}</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Default Penalty Payment Frequency</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">{{ $PAT }}</p>
  </div>

   @elseif($VBM == "Rental")
   <div class="form-group row">
    <label class="col-6 col-form-label">Status</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">Customer</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Business</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">{{ $VBM }}</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Vehicle No</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">{{ $VNO }}</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Security Deposit (Refundable)</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">{{ $SDP }}</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Payment (Amount)</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">{{ $VAM }}</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Payment Frequency</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">{{ $VPF }}</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Contract End Date</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">{{ $CEX }}</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">First Payment (Date)</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">N/A</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Last Payment (Date)</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">N/A</p>
  </div>

  @else
 <div class="form-group row">
    <label class="col-6 col-form-label">Status</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">Independent Contractor</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Business</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">{{ $VBM }}</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Vehicle No</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">{{ $VNO }}</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Security Deposit (Refundable)</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">{{ $SDP }}</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Remuneration</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">N/A</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Target Amount (Bonus)</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">N/A</p>
  </div>
   <div class="form-group row">
    <label class="col-6 col-form-label">Sales Declaration</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">Daily</p>
  </div> 
  <div class="form-group row">
    <label class="col-6 col-form-label">Contract End Date</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">{{ $CEX }}</p>
  </div>
   @endif
</div>
  <nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">
   <a href="{{ route('myaccount') }}" class="btn btn-info">Back</a>&nbsp;      
    <a href="{{ route('driver') }}" class="btn btn-info">Logout</a>
  </nav>

</div>
</div>

@endsection