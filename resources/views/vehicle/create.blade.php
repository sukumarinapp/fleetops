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
		<div class="row mb-2">
			<div class="col-sm-6">
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
					<li class="breadcrumb-item">Operations</li>
					<li class="breadcrumb-item"><a href="{{ route('vehicle.index') }}">Vehicle</a></li>
					<li class="breadcrumb-item">Add Vehicle</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="card card-info">
	<div class="card-header">
		<h3 class="card-title">Add Vehicle</h3>
	</div>
	<div class="table-responsive">
		<div class="card-body">
			@if(session()->has('error'))
			<div class="alert alert-danger alert-dismissable" style="margin: 15px;">
				<a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong> {{ session('error') }} </strong>
			</div>
			@endif
			<form action="{{ route('vehicle.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
				@csrf
				<div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label for="CAN" class="col-sm-4 col-form-label"><span style="color:red">*</span>Customer Account #</label>
							<div class="col-sm-8">
								<select required="required" class="form-control select2" name="CAN" id="CAN" >
									@foreach($clients as $client)
									<option value="{{ $client->UAN }}" >{{ $client->UAN }}-{{ $client->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label for="VNO" class="col-sm-4 col-form-label"><span style="color:red">*</span>Vehicle Reg. No.</label>
							<div class="col-sm-8">
								<input onkeyup="duplicateVNO(0)" required="required" type="text" class="form-control" name="VNO" id="VNO" maxlength="50" placeholder="Vehicle Reg. No.">
								<span id="dupVNO" style="color:red"></span>
							</div>
						</div>
						<div class="form-group row">
							<label for="VID" class="col-sm-4 col-form-label"><span style="color:red">*</span>Insurance<br>&nbsp;File Type (pdf/jpg/png)</label>
							<div class="col-sm-8">
								<input required="required" accept="application/pdf,image/png, image/jpeg" name="VID" type="file" id="VID">
							</div>
						</div>

						<div class="form-group row">
							<label for="IEX" class="col-sm-4 col-form-label"><span style="color:red">*</span>Insurance Expiry Date</label>
							<div class="col-3">
								<input min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required="required" onkeydown="return false" type="date" class="form-control" name="IEX" id="IEX" >
							</div>
							<div class="col-sm-5">
								<label>Reminder</label>
								<label class="switch">
									<input name="AVI" id="AVI" type="checkbox">
									<span class="slider round"></span>
								</label>
							</div>
						</div>
						<div class="form-group row">
							<label for="VRD" class="col-sm-4 col-form-label"><span style="color:red">*</span>Roadworthy Cert<br>&nbsp;File Type (pdf/jpg/png)</label>
							<div class="col-sm-8">
								<input required="required" accept="application/pdf,image/png, image/jpeg" name="VRD" type="file" id="VRD">
							</div>
						</div>

						<div class="form-group row">
							<label for="REX" class="col-sm-4 col-form-label"><span style="color:red">*</span>Roadworthy Expiry Date</label>
							<div class="col-3">
								<input min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required="required" onkeydown="return false" type="date" class="form-control" name="REX" id="REX" >
							</div>
							<div class="col-5">
								<label>Reminder</label>
								<label class="switch">
									<input name="AVR" id="AVR" type="checkbox">
									<span class="slider round"></span>
								</label>
							</div>
						</div>
						<div class="form-group row">
							<label for="VMK" class="col-sm-4 col-form-label"><span style="color:red"></span>Make</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="VMK" id="VMK" maxlength="50" placeholder="Make">
							</div>
						</div>
						<div class="form-group row">
							<label for="VMD" class="col-sm-4 col-form-label"><span style="color:red"></span>Model</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="VMD" id="VMD" maxlength="50" placeholder="Model">
							</div>
						</div>
						<div class="form-group row">
							<label for="VCL" class="col-sm-4 col-form-label"><span style="color:red"></span>Color</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="VCL" id="VCL" maxlength="50" placeholder="Color">
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group row">
							<button type="button" class="btn btn-outline-primary float-right" data-toggle="modal" data-target="#RH-Fuel"><i class="nav-icon fa fa-gas-pump"></i> RH Fuel Settings
							</button>

						</div>

						<div class="modal fade" id="RH-Fuel">
							<div class="modal-dialog modal-xl">
								<div class="modal-content">
									<div class="modal-header">
										<h6 class="modal-title">RH Fuel Settings</h6>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">

										<div class="form-group row">
											<label for="ECY" class="col-sm-4 col-form-label"><span style="color:red">*</span>RH – Engine Capacity (Litres)</label>
											<div class="col-sm-8">
												<input required="required" type="text" class="form-control decimal" name="ECY" id="ECY" maxlength="10" placeholder="Engine Capacity">
											</div>
										</div>
										<div class="form-group row">
											<label for="VFT" class="col-sm-4 col-form-label"><span style="color:red">*</span>RH – Tank Capacity (Litres)</label>
											<div class="col-sm-8">
												<input required="required" type="text" class="form-control decimal" name="VFT" id="VFT" maxlength="10" placeholder="Tank Capacity">
											</div>
										</div>
										<div class="form-group row">
											<label for="VFC" class="col-sm-4 col-form-label"><span style="color:red">*</span>RH – Fueling Cap (Litres)</label>
											<div class="col-sm-8">
												<input required="required" type="text" class="form-control decimal" name="VFC" id="VFC" maxlength="10" placeholder="Fueling Cap (%)">
											</div>
										</div>

										<div class="form-group row">
											<div class="col-md-12 text-center">
												<button type="button" class="btn btn-primary" data-dismiss="modal">Confirm</button>
											</div>
										</div>	
									</div>
								</div>
							</div>
						</div> 

						<div class="form-group row">
							<button type="button" class="btn btn-outline-primary float-right" data-toggle="modal" data-target="#tracker"><i class=" nav-icon fas fa-cog"></i>Tracker settings
							</button>
						</div>
						<div class="modal fade" id="tracker">
							<div class="modal-dialog modal-xl">
								<div class="modal-content">
									<div class="modal-header">
										<h6 class="modal-title">Tracker settings</h6>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">

										<div class="form-group row">
											<label for="TSN" class="col-sm-4 col-form-label"><span style="color:red">*</span>Tracker Device SN</label>
											<div class="col-sm-8">
												<input onkeyup="duplicateDeviceSN(0)" required="required" type="text" class="form-control" name="TSN" id="TSN" maxlength="50" placeholder="Tracker Device SN">
												<span id="dupTSN" style="color:red"></span>
											</div>
										</div>
										<div class="form-group row">
											<label for="TID" class="col-sm-4 col-form-label"><span style="color:red">*</span>Tracker ID</label>
											<div class="col-sm-8">
												<input onkeyup="duplicateTrackerID(0)" required="required" type="text" class="form-control" name="TID" id="TID" maxlength="50" placeholder="Tracker ID">
												<span id="dupTID" style="color:red"></span>
											</div>
										</div>
										<div class="form-group row">
											<label for="TSM" class="col-sm-4 col-form-label"><span style="color:red">*</span>Tracker SIM No.</label>
											<div class="col-sm-8">
												<input onkeyup="duplicateTrackerSIM(0)" required="required" type="text" class="form-control" name="TSM" id="TSM" maxlength="50" placeholder="Tracker SIM No.">
												<span id="dupTSM" style="color:red"></span>
											</div>
										</div>
										<div class="form-group row">
											<label for="TIP" class="col-sm-4 col-form-label"><span style="color:red">*</span>Terminal IP Address</label>
											<div class="col-sm-8">
												<input required="required" type="text" class="form-control" name="TIP" id="TIP" maxlength="50" placeholder="Terminal IP Address">
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<!-- text input -->
												<div class="form-group row">
													<label for="VZC1" class="col-sm-6 col-form-label"><span style="color:red">*</span>Buzzer (On)</label>
													<div class="col-sm-6">
														<input required="required" type="text" class="form-control" name="VZC1" id="VZC1" maxlength="50" placeholder="Code">
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group row">
													<label for="VZC0" class="col-sm-6 col-form-label"><span style="color:red">*</span>Buzzer (Off)</label>
													<div class="col-sm-6">
														<input required="required" type="text" class="form-control" name="VZC0" id="VZC0" maxlength="50" placeholder="Code">
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<!-- text input -->
												<div class="form-group row">
													<label for="VBC1" class="col-sm-6 col-form-label"><span style="color:red">*</span>Blocking (On)</label>
													<div class="col-sm-6">
														<input required="required" type="text" class="form-control" name="VBC1" id="VBC1" maxlength="50" placeholder="Code">
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group row">
													<label for="VBC0" class="col-sm-6 col-form-label"><span style="color:red">*</span>Blocking (Off):</label>
													<div class="col-sm-6">
														<input required="required" type="text" class="form-control" name="VBC0" id="VBC0" maxlength="50" placeholder="Code">
													</div>
												</div>
											</div>
										</div>

										<div class="form-group row">
											<div class="col-md-12 text-center">
												<button type="button" class="btn btn-primary" data-dismiss="modal">Confirm</button>
											</div>
										</div>	
									</div>
								</div>
							</div>
						</div> 


						<div class="form-group row">
							<button type="button" class="btn btn-outline-primary float-right" data-toggle="modal" data-target="#modal-default"><i class="nav-icon fas fa-cog"></i> Maintenance Scheduler
							</button>

							<label for="MSH" class="col-sm-2 col-form-label">Scheduler</label>
							<div class="col-sm-2" style="margin-top:10px">
								<label class="switch">
									<input name="MSH" id="MSH" type="checkbox">
									<span class="slider round"></span>
								</label>
							</div>

						</div>
					</div>
					<!-- /.col -->
				</div>
				<div class="form-group row">
					<div class="col-sm-6">
						<div class="form-check">
							<input value="1" type="checkbox" name="VTV" class="form-check-input" id="VTV">
							<label class="form-check-label text-success" for="VTV"><b>Activate Account</b></label>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-12 text-center">
						<input id="save" required="required" class="btn btn-info"	type="submit" name="submit" value="Save"/>
						<a href="{{ route('vehicle.index') }}" class="btn btn-info">Back</a>
					</div>
				</div>	
			</div>
		</div>

		<div class="modal fade" id="modal-default">
			<div class="modal-dialog modal-xl">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title">Maintenance Scheduler</h6>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<label>Service Scheduling</label>
						<div class="form-group row">
							<label for="SSD" class="col-sm-3 col-form-label">Next Scheduled Date</label>
							<div class="col-sm-2">
								<input value="{{ date('Y-m-d') }}" onkeydown="return false" type="date" class="form-control" name="SSD" id="SSD" >
							</div>

							<label for="SSM" class="col-sm-3 col-form-label">(or) Next Scheduled Mileage</label>
							<div class="col-sm-2">
								<input maxlength="6" type="text" class="form-control number" name="SSM" id="SSM" >
							</div>
						</div>

						<div class="form-group row">
							<label for="RSS" class="col-sm-1 col-form-label">Recurring</label>
							<div class="col-sm-2" style="margin-top:10px">
								<label class="switch">
									<input name="RSS" id="RSS" type="checkbox">
									<span class="slider round"></span>
								</label>
							</div>
							<label for="SMF" class="col-sm-2 col-form-label">Recurrence</label>
							<div class="col-sm-2">
								<input type="text" maxlength="6" class="form-control number" name="SMF" id="SMF" placeholder="Every Km" >
							</div>
							<label for="SSF" class="col-sm-1 col-form-label">(or)</label>
							<div class="col-sm-2">
								<select name="SSF" id="SSF" class="custom-select">
									<option value="Daily" selected="selected">Daily</option>
									<option value="Weekly" >Weekly</option>
									<option value="Monthly" >Monthly</option>
									<option value="Yearly" >Yearly</option>
								</select>
							</div>
						</div>

						<div class="form-group row">
							<div class="col-sm-3">
							</div>
							<label for="SSFP" class="col-sm-2 col-form-label">Recur Every</label>
							<div class="col-sm-2">
								<input type="text" maxlength="2" class="form-control number" name="SSFP" id="SSFP">
							</div>

							<label for="SSFD" class="col-sm-1 col-form-label">On Day</label>
							<div class="col-sm-2">
								<select name="SSFD" id="SSFD" class="custom-select">
									<option value="0" selected="selected">Sunday</option>
									<option value="1" >Monday</option>
									<option value="2" >Tuesday</option>
									<option value="3" >Wednesday</option>
									<option value="4" >Thursday</option>
									<option value="5" >Friday</option>
									<option value="6" >Saturday</option>
								</select>
							</div>
						</div>								

						<br><label>Vehicle Inspection Scheduling</label>
						<div class="form-group row">
							<label for="ISD" class="col-sm-3 col-form-label">Next Scheduled Date</label>
							<div class="col-sm-2">
								<input value="{{ date('Y-m-d') }}" onkeydown="return false" type="date" class="form-control" name="ISD" id="ISD" >
							</div>

							<label for="ISM" class="col-sm-3 col-form-label">(or) Next Scheduled Mileage</label>
							<div class="col-sm-2">
								<input type="text" maxlength="6" class="form-control number" name="ISM" id="ISM" >
							</div>
						</div>

						<div class="form-group row">
							<label for="RIS" class="col-sm-1 col-form-label">Recurring</label>
							<div class="col-sm-2" style="margin-top:10px">
								<label class="switch ">
									<input name="RIS" id="RIS" type="checkbox">
									<span class="slider round"></span>
								</label>
							</div>
							<label for="IMF" class="col-sm-2 col-form-label">Recurrence</label>
							<div class="col-sm-2">
								<input type="text" maxlength="6" class="form-control number" name="IMF" id="IMF" placeholder="Every Km" >
							</div>
							<label for="ISF" class="col-sm-1 col-form-label">(or)</label>
							<div class="col-sm-2">
								<select name="ISF" id="ISF" class="custom-select">
									<option value="Daily" selected="selected">Daily</option>
									<option value="Weekly" >Weekly</option>
									<option value="Monthly" >Monthly</option>
									<option value="Yearly" >Yearly</option>
								</select>
							</div>
						</div>

						<div class="form-group row">
							<div class="col-sm-3">
							</div>
							<label for="ISFP" class="col-sm-2 col-form-label">Recur Every</label>
							<div class="col-sm-2">
								<input type="text" maxlength="2" class="form-control number" name="ISFP" id="ISFP">
							</div>

							<label for="ISFD" class="col-sm-1 col-form-label">On Day</label>
							<div class="col-sm-2">
								<select name="ISFD" id="ISFD" class="custom-select">
									<option value="0" selected="selected">Sunday</option>
									<option value="1" >Monday</option>
									<option value="2" >Tuesday</option>
									<option value="3" >Wednesday</option>
									<option value="4" >Thursday</option>
									<option value="5" >Friday</option>
									<option value="6" >Saturday</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12 text-center">
								<button type="button" class="btn btn-primary" data-dismiss="modal">Confirm</button>
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>
		</form> 
	</section>

	@endsection
	@push('page_scripts')
	<script>
		$(document).ready(function(){
			$('.select2').select2({
				theme: 'bootstrap4'
			});
		});
	</script>
	@endpush