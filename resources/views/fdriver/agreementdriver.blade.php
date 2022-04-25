@extends('layouts.app')

@section('content')
   <div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			      <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item">Operations</li>
              <li class="breadcrumb-item"><a href="{{ route('fdriver.index') }}">Driver</a></li>
              <li class="breadcrumb-item">Add Driver</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
			<div class="card card-info">
			<div class="card-header">
			<h3 class="card-title">HIRE-PURCHASE AGREEMENT SUMMARY</h3>
			</div>

          <div class="card-body">
            <div class="row">
              <div class="col-md-8">
<div class="form-group row">
    <label class="col-6 col-form-label">Status</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label">Customer</p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Business</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label"></p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Vehicle No</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label"></p>
  </div>
    <div class="form-group row">
    <label class="col-6 col-form-label">Purchase Price</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label"></p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Down Payment</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label"></p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Security Deposit (Refundable):
    </label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label"></p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Term</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label"></p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Payment (Amount)</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label"></p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Payment Frequency</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label"></p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Contract End Date</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label"></p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">First Payment (Date)</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label"></p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Last Payment (Date)</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label"></p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">No of Installments</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label"></p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Default Penalty Applicable</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label"></p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">No of Defaults Allowed</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label"></p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Default Penalty Amount</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label"></p>
  </div>
  <div class="form-group row">
    <label class="col-6 col-form-label">Default Penalty Payment Frequency</label>
    <label class="col-1 col-form-label">:</label>
    <p class="col-5 col-form-label"></p>
  </div>
									</div>
          </div>
         
        </div>
 <div class="form-group row">
					<div class="col-md-12 text-center">
              <a href="{{ route('fdriver.index') }}" class="btn btn-info">Back</a>
					</div>
				</div>	
		
        </div>
				  </div>
    </section>
   
@endsection
