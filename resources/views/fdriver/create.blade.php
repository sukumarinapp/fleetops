@extends('layouts.app')

@section('content')
<style type="text/css">
	.switch {
		position: relative;
		display: inline-block;
		width: 45px;
		height: 24px;
	}

	.switch input { 
		opacity: 0;
		width: 0;
		height: 0;
	}

	.slider {
		position: absolute;
		cursor: pointer;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: #ccc;
		-webkit-transition: .4s;
		transition: .4s;
	}

	.slider:before {
		position: absolute;
		content: "";
		height: 16px;
		width: 18px;
		left: 4px;
		bottom: 4px;
		background-color: white;
		-webkit-transition: .4s;
		transition: .4s;
	}

	input:checked + .slider {
		background-color: #2196F3;
	}

	input:focus + .slider {
		box-shadow: 0 0 1px #2196F3;
	}

	input:checked + .slider:before {
		-webkit-transform: translateX(20px);
		-ms-transform: translateX(20px);
		transform: translateX(20px);
	}

	.slider.round {
		border-radius: 34px;
	}

	.slider.round:before {
		border-radius: 34px;
	}
</style>
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
			<h3 class="card-title">Add Driver</h3>
			</div>

          <div class="card-body">
		    	@if(session()->has('error'))
                    <div class="alert alert-danger alert-dismissable" style="margin: 15px;">
                        <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong> {{ session('error') }} </strong>
                    </div>
                @endif
                <form onsubmit="return validate_amount()" action="{{ route('fdriver.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
					<label for="DNM" class="col-sm-4 col-form-label"><span style="color:red">*</span>Driver Name</label>
					<div class="col-sm-8">
						<input required="required" type="text" class="form-control" name="DNM" id="DNM" maxlength="30" placeholder="Driver Name">
					</div>
				</div>
				
				<div class="form-group row">
					<label for="DSN" class="col-sm-4 col-form-label"><span style="color:red">*</span>Driver Surname</label>
					<div class="col-sm-8">
						<input required="required" type="text" class="form-control" name="DSN" id="DSN" maxlength="30" placeholder="Driver Surname">
					</div>
				</div>
				<div class="form-group row">
					<label for="DNO" class="col-sm-4 col-form-label"><span style="color:red">*</span>License Number</label>
					<div class="col-sm-8">
						<input onkeyup="duplicateDNO(0)" required="required" type="text" class="form-control" name="DNO" id="DNO" maxlength="25" placeholder="License Number">
						<span id="dupDNO" style="color:red"></span>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="DLD" class="col-sm-4 col-form-label"><span style="color:red"></span>License</label>
					<div class="col-sm-8">
                        <input accept="application/pdf,image/png, image/jpeg" required="required" name="DLD" type="file" id="DLD">
					</div>
				</div>
				<div class="form-group row">
										<label for="LEX" class="col-sm-4 col-form-label"><span style="color:red">*</span>License Expiry Date</label>
										<div class="col-6">
											<input required="required" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" onkeydown="return false" type="date" class="form-control" name="LEX" id="LEX" >
										</div>
										<div class="col-2">
											<label class="switch">
												<input name="AVL" id="AVL" type="checkbox">
												<span class="slider round"></span>
											</label>
										</div>
									</div>
                <div class="form-group row">
					<label for="VCC" class="col-sm-4 col-form-label"><span style="color:red"></span>Contract</label>
					<div class="col-sm-8">
                        <input accept="application/pdf" required="required" name="VCC" type="file" id="VCC">
					</div>
				</div>
				<div class="form-group row">
										<label for="CEX" class="col-sm-4 col-form-label"><span style="color:red">*</span>Contract Expiry Date</label>
										<div class="col-6">
											<input required="required" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" onkeydown="return false" type="date" class="form-control" name="CEX" id="CEX" >
										</div>
										<div class="col-2">
											<label class="switch">
												<input name="AVC" id="AVC" type="checkbox">
												<span class="slider round"></span>
											</label>
										</div>
									</div>
 				<div class="form-group row">
					<label for="DCN" class="col-sm-4 col-form-label"><span style="color:red">*</span>Contact Number</label>
					<div class="col-sm-8">
						<input required="required" type="text" class="form-control number" name="DCN" id="DCN" maxlength="15" placeholder="Contact Number">
						<!-- <input onkeyup="checkDCN(0)" required="required" type="text" class="form-control number" name="DCN" id="DCN" maxlength="15" placeholder="Contact Number"> -->
					</div>
					<div class="col-sm-4">
        <span id="dupContact" style="color:red"></span>
    </div>
				</div>
				<div class="form-group row">
										<label for="VPL" class="col-sm-4 col-form-label"><span style="color:red"></span>Parking Location</label>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="VPL" id="VPL" maxlength="50" placeholder="location">
										</div>
										<div class="col-sm-1">
              <span><i onclick="select_parking()" class="nav-icon fa fa-map-marker" style="font-size:30px"></i></span>
             </div>
									</div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
              	
					<div class="form-group row">
					<label for="VBM" class="col-sm-4 col-form-label"><span style="color:red"></span>Business Model</label>
					<div class="col-sm-8">
						 <select name="VBM" id="VBM" class="custom-select">
                <option value="Ride Hailing" selected="selected">Ride Hailing</option>
                <option value="Rental" >Rental</option>
                <option value="Hire Purchase" >Hire Purchase</option>
              </select>
					</div>
				</div>
               <div class="form-group row" id="rhdiv">
										<label for="PLF" class="col-sm-4 col-form-label"><span style="color:red"></span>RH Platform</label>
										<div class="col-4">
											<select name="PLF[]" id="multidropdown" class="custom-select">
                         @foreach($rhplatforms as $rhplatform)
	                     	<option value="{{ $rhplatform->id }}" >{{ $rhplatform->RHN }}</option>
	                     @endforeach
                        </select>
										</div>
										<label for="DVE" class="col-sm-2 col-form-label"><span style="color:red"></span>Set Earnings</label>
										<div class="col-sm-2" style="margin-top:10px">
											<label class="switch">
												<input name="DVE" id="DVE" type="checkbox">
												<span class="slider round"></span>
											</label>
										</div>
									</div>
				<div class="form-group row" id="freqdiv" style="display: none;">
					<label for="VPF" class="col-sm-4 col-form-label"><span style="color:red"></span>Frequency</label>
					<div class="col-sm-8">
						 <select name="VPF" id="VPF" class="custom-select">
                         <option value="Daily" selected="selected">Daily</option>
                         <option value="Weekly" >Weekly</option>
                         <option value="Monthly" >Monthly</option>
                        </select>
					</div>
				</div>

				<div class="form-group row" id="weekdaydiv" style="display: none;">
					<label for="WDY" class="col-sm-4 col-form-label"><span style="color:red"></span>Weekday</label>
					<div class="col-sm-8">
						 <select name="WDY" id="WDY" class="custom-select">
               <option value="0" >Sunday</option>
               <option value="1" selected="selected">Monday</option>
               <option value="2">Wednesday</option>
               <option value="3">Thursday</option>
               <option value="4">Tuesday</option>
               <option value="5">Friday</option>
               <option value="6">Saturday</option>
              </select>
					</div>
				</div>

					<div class="form-group row" id="monthdaydiv" style="display: none;">
					<label for="MDY" class="col-sm-4 col-form-label"><span style="color:red"></span>Day of Month</label>
					<div class="col-sm-8">
						 <select name="MDY" id="MDY" class="custom-select">
               <option value="1" selected="selected">01</option>
               @for ($i = 2; $i < 28; $i++)

							    <option value="{{ $i }}" >{{ str_pad($i, 2 , "0",STR_PAD_LEFT) }}</option>
							 @endfor
							 <option value="31" >Last Day of Month</option>
              </select>
					</div>
				</div>


				 <div class="form-group row" id="paydatediv" style="display: none;">
					<label for="VPD" class="col-sm-4 col-form-label"><span style="color:red"></span>First Payment Date</label>
					<div class="col-sm-8">
						<input min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" onkeydown="return false" type="date" class="form-control" name="VPD" id="VPD" maxlength="10" placeholder="First Payment Date">
					</div>
				</div>
				
				<div class="form-group row" id="payamtdiv" style="display: none;">
					<label for="VAM" class="col-sm-4 col-form-label"><span style="color:red"></span>Recurring Amount</label>
					<div class="col-sm-8">
						<input type="text" class="form-control decimal" name="VAM" id="VAM" maxlength="10" placeholder="Recurring Amount">
					</div>
				</div>

         <div class="form-group row" id="purchasediv" style="display: none;">
					<label for="PPR" class="col-sm-4 col-form-label"><span style="color:red"></span>Purchase Price</label>
					<div class="col-sm-8">
						<input type="text" class="form-control decimal" name="PPR" id="PPR" maxlength="10" placeholder="Purchase Price">
					</div>
				</div>

            <div class="form-group row" id="dowmamtdiv" style="display: none;">
					<label for="PDP" class="col-sm-4 col-form-label"><span style="color:red"></span>Down Payment</label>
					<div class="col-sm-8">
						<input type="text" class="form-control decimal" name="PDP" id="PDP" maxlength="10" placeholder="Down Payment">
					</div>
				</div>

           <div class="form-group row" id="depositdiv" style="display: none;">
					<label for="SDP" class="col-sm-4 col-form-label"><span style="color:red"></span>Security Deposit (Refundable)</label>
					<div class="col-sm-8">
						<input type="text" class="form-control decimal" name="SDP" id="SDP" maxlength="10" placeholder="Security Deposit">
					</div>
				</div>

				<div class="form-group row" style="padding-top:50px;display: none;" id="penalty">
                    <label  class="form-check-label col-sm-7" for="EPD"><b>Enable Penalty Rule on Payment Defaults</b></label>
                     <div class="icheck-success d-inline col-sm-1">
                        <input name="EPD" type="checkbox" id="EPD">
                    </div> 
				</div>

				<div class="form-group row" id="def" style="display: none;">
										<label for="NOD" class="col-sm-5 col-form-label"><span style="color:red"></span>Number of Defaults Allowed</label>
										<div class="col-2">
											<input maxlength="2" type="text" class="form-control number" name="NOD" id="NOD" >
										</div>
										<div class="col-5">
											<div class="icheck-primary d-inline">
                        <input value="0" checked type="radio" id="Consecutive" name="NODB" />
                        <label for="NODB">
                        </label><b>Consecutive</b>
                      </div><br>
                       <div class="icheck-primary d-inline">
                        <input value="1" type="radio" id="Total" name="NODB" />
                        <label for="NODB">
                        </label><b>Total</b>
                      </div>
										</div>
									</div>

										<div class="form-group row" id="pen" style="display: none;">
										<label for="PAM" class="col-sm-5 col-form-label">Penalty Amount:</label>
										<div class="col-2">
											<input maxlength="5" type="text" class="form-control number" name="PAM" id="PAM" >
										</div>
										
											<label for="CEX" class="col-sm-1 col-form-label">per</label>
										<div class="col-sm-4">
						 <select name="PAT" id="PAT" class="custom-select">
               <option value="Daily" >Daily</option>
               <option value="Weekly" >Weekly</option>
               <option value="Monthly" selected="selected">Monthly</option>
              </select>
					</div>
									</div>

									<div class="form-group row" id="due" style="display: none;">
										<p class="col-form-label">The total aggregated sum of penalty amount charged at stated frequency shall be added to next payment due.</p>
									</div>
									</div>
          </div>
         
        </div>
 <div class="form-group row">
					<div class="col-md-12 text-center">
						<input required="required" class="btn btn-info"
						type="submit" id="save" name="submit" value="Save"/>
                        <a href="{{ route('fdriver.index') }}" class="btn btn-info">Back</a>
					</div>
				</div>	
		
        </div>
				  </div>
    </section>
   
@endsection

@section('third_party_scripts')
<script>
	function select_parking(){
		latitude = "5.605884551566098";
		longitude = "-0.19313015133623626";
		window.open("https://maps.google.com/?q="+latitude+","+longitude);
	}
</script>
@endsection