@extends('layouts.app')

@section('content')
<style type="text/css">		.switch {
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
}</style>
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
								<li class="breadcrumb-item"><a href="{{ route('vehicle.index') }}">vehicle</a></li>
								<li class="breadcrumb-item">Edit Vehicle</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
			<div class="card card-info">
				<div class="card-header">
					@if($online == 1)
					<img align="left" src="/online.jpg" />
					@else
					<img align="left" src="/offline.jpg" /> 
					@endif
					<h3 class="card-title" >&nbsp;Edit Vehicle</h3>
				</div>


				<div class="card-body">
					@if(session()->has('error'))
					<div class="alert alert-danger alert-dismissable" style="margin: 15px;">
						<a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong> {{ session('error') }} </strong>
					</div>
					@endif
					
<form onsubmit="return validate_all(event);"  action="{{ route('vehicle.update',$vehicle->id) }}" method="post" enctype="multipart/form-data" class="form-horizontal">
						@csrf
						@method('PUT')
						<div class="row">
							<div class="col-md-6">
								<div class="form-group row">
									<label for="CAN" class="col-sm-4 col-form-label"><span style="color:red">*</span>Customer Account #</label>
									<div class="col-sm-8">
										<select required="required" class="form-control select2" name="CAN" id="CAN" >
											@foreach($clients as $client)
											<option {{ ($vehicle->CAN == $client->UAN ? "selected":"") }} value="{{ $client->UAN }}" >{{ $client->UAN }}-{{ $client->name }}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label for="VNO" class="col-sm-4 col-form-label"><span style="color:red">*</span>Vehicle Reg. No.</label>
									<div class="col-sm-8">
										<input onkeyup="duplicateVNO( {{ $vehicle->id }} )" value="{{ $vehicle->VNO }}" required="required" type="text" class="form-control" name="VNO" id="VNO" maxlength="50" placeholder="Vehicle Reg. No.">
										<span id="dupVNO" style="color:red"></span>
									</div>
								</div>

								<div class="form-group row">
									<label for="VID" class="col-sm-4 col-form-label"><span style="color:red">*</span>Insurance<br>&nbsp;File Type (pdf/jpg/png)</label>
									<div class="col-sm-8">
										<input onchange="readURL(this,'ins');" accept="application/pdf,image/png, image/jpeg" name="VID" type="file" id="VID">
										@php
										$href="";
										if($vehicle->VID != ""){
											echo "<a target='_blank' href='../../uploads/VID/".$vehicle->VID."'>View</a>";
										}
										@endphp
										<img id="ins"  />
									</div>
								</div>

								<div class="form-group row">
									<label for="VID" class="col-sm-4 col-form-label"><span style="color:red">*</span>Insurance Expiry Date</label>
									<div class="col-sm-5">
										<input min="{{ date('Y-m-d') }}" value="{{ $vehicle->IEX }}" required="required" onkeydown="return false" type="date" class="form-control" name="IEX" id="IEX" >
									</div>
										<label class="col-form-label">Reminder</label>&nbsp;
										<label class="switch" style="margin-top:10px">
											<input {{ ($vehicle->AVI == "1" ? "checked":"") }}  name="AVI" id="AVI" type="checkbox">
											<span class="slider round"></span>
										</label>
								</div>
								<div class="form-group row">
									<label for="VRD" class="col-sm-4 col-form-label"><span style="color:red">*</span>Roadworthy Cert<br>&nbsp;File Type (pdf/jpg/png)</label>
									<div class="col-sm-8">
										<input onchange="readURL(this,'rdw');" accept="application/pdf,image/png, image/jpeg" name="VRD" type="file" id="VRD">
										@php
										$href="";
										if($vehicle->VRD != ""){
											echo "<a target='_blank' href='../../uploads/VRD/".$vehicle->VRD."'>View</a>";
										}
										@endphp
										<img id="rdw"  />
									</div>
								</div>

								<div class="form-group row">
									<label for="REX" class="col-sm-4 col-form-label"><span style="color:red">*</span>Roadworthy Expiry Date</label>
									<div class="col-sm-5">
										<input min="{{ date('Y-m-d') }}" value="{{ $vehicle->REX }}" required="required" onkeydown="return false" type="date" class="form-control" name="REX" id="REX" >
									</div>
										<label class="col-form-label">Reminder</label>&nbsp;
										<label class="switch" style="margin-top:10px">
											<input {{ ($vehicle->AVR == "1" ? "checked":"") }}  name="AVR" id="AVR" type="checkbox">
											<span class="slider round"></span>
										</label>
								</div>
								<div class="form-group row">
									<label for="VMK" class="col-sm-4 col-form-label"><span style="color:red"></span>Make</label>
									<div class="col-sm-8">
										<input value="{{ $vehicle->VMK }}" type="text" class="form-control" name="VMK" id="VMK" maxlength="50" placeholder="Make">
									</div>
								</div>
								<div class="form-group row">
									<label for="VMD" class="col-sm-4 col-form-label"><span style="color:red"></span>Model</label>
									<div class="col-sm-8">
										<input value="{{ $vehicle->VMD }}" type="text" class="form-control" name="VMD" id="VMD" maxlength="50" placeholder="Model">
									</div>
								</div>
								<div class="form-group row">
									<label for="VCL" class="col-sm-4 col-form-label"><span style="color:red"></span>Color</label>
									<div class="col-sm-8">
										<input value="{{ $vehicle->VCL }}" type="text" class="form-control" name="VCL" id="VCL" maxlength="50" placeholder="Color">
									</div>
								</div>
								<div class="form-group row">
									<label for="chassis_no" class="col-sm-4 col-form-label"><span style="color:red"></span>Vehicle Chassis No</label>
									<div class="col-sm-8">
										<input value="{{ $vehicle->chassis_no }}" type="text" class="form-control" name="chassis_no" id="chassis_no" maxlength="50" placeholder="Vehicle Chassis No">
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group row">
									<button type="button" class="btn btn-outline-primary float-right" data-toggle="modal" data-target="#RH-Fuel"><i class="fa fa-gas-pump"></i> RH Fuel Settings
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
														<input value="{{ $vehicle->ECY }}" required="required" type="text" class="form-control decimal" name="ECY" id="ECY" maxlength="10" placeholder="Engine Capacity">
													</div>
												</div>

												<div class="form-group row">
													<label for="CON" class="col-sm-4 col-form-label"><span style="color:red">*</span>Fuel Consumption</label>
													<div class="col-sm-8">
														<input  value="{{ number_format((float)$vehicle->CON, 2, '.', '') }}" required="required" type="text" readonly class="form-control decimal" name="CON" id="CON" maxlength="10" placeholder="Fuel Consumption">
													</div>
												</div>
												<div class="form-group row">
													<label for="VFT" class="col-sm-4 col-form-label"><span style="color:red">*</span>RH – Tank Capacity (Litres)</label>
													<div class="col-sm-8">
														<input value="{{ $vehicle->VFT }}" required="required" type="text" class="form-control decimal" name="VFT" id="VFT" maxlength="10" placeholder="Tank Capacity">
													</div>
												</div>
												<div class="form-group row">
													<label for="VFC" class="col-sm-4 col-form-label"><span style="color:red">*</span>RH – Fueling Cap (Litres)</label>
													<div class="col-sm-8">
														<input value="{{ $vehicle->VFC }}" required="required" type="text" class="form-control decimal" name="VFC" id="VFC" maxlength="10" placeholder="Fueling Cap (%)">
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
														<input onkeyup="duplicateDeviceSN( {{ $vehicle->TSN }} )" value="{{ $vehicle->TSN }}" required="required" type="text" class="form-control" name="TSN" id="TSN" maxlength="50" placeholder="Tracker Device SN">
														<span id="dupTSN" style="color:red"></span>
													</div>
												</div>
												<div class="form-group row">
													<label for="TID" class="col-sm-4 col-form-label"><span style="color:red">*</span>Tracker ID</label>
													<div class="col-sm-8">
														<input onkeyup="duplicateTrackerID( {{ $vehicle->TID }} )" value="{{ $vehicle->TID }}" required="required" type="text" class="form-control" name="TID" id="TID" maxlength="50" placeholder="Tracker ID">
													</div>
												</div>
												<div class="form-group row">
													<label for="TSM" class="col-sm-4 col-form-label"><span style="color:red">*</span>Tracker SIM No.</label>
													<div class="col-sm-8">
														<input onkeyup="duplicateTrackerSIM( {{ $vehicle->TSM }} )" value="{{ $vehicle->TSM }}" required="required" type="text" class="form-control" name="TSM" id="TSM" maxlength="50" placeholder="Tracker SIM No.">
														<span id="dupTSM" style="color:red"></span>
													</div>
												</div>
												<div class="form-group row">
													<label for="TIP" class="col-sm-4 col-form-label"><span style="color:red">*</span>Terminal IP Address</label>
													<div class="col-sm-8">
														<input value="{{ $vehicle->TIP }}" required="required" type="text" class="form-control" name="TIP" id="TIP" maxlength="50" placeholder="Terminal IP Address">
													</div>
												</div>
												<div class="row">
													<div class="col-sm-6">
														<!-- text input -->
														<div class="form-group row">
															<label for="VZC1" class="col-sm-6 col-form-label"><span style="color:red">*</span>Buzzer (On)</label>
															<div class="col-sm-6">
																<input value="{{ $vehicle->VZC1 }}" required="required" type="text" class="form-control" name="VZC1" id="VZC1" maxlength="50" placeholder="Code">
															</div>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group row">
															<label for="VZC0" class="col-sm-6 col-form-label"><span style="color:red">*</span>Buzzer (Off)</label>
															<div class="col-sm-6">
																<input value="{{ $vehicle->VZC0 }}" required="required" type="text" class="form-control" name="VZC0" id="VZC0" maxlength="50" placeholder="Code">
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
																<input value="{{ $vehicle->VBC1 }}" required="required" type="text" class="form-control" name="VBC1" id="VBC1" maxlength="50" placeholder="Code">
															</div>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group row">
															<label for="VBC0" class="col-sm-6 col-form-label"><span style="color:red">*</span>Blocking (Off):</label>
															<div class="col-sm-6">
																<input value="{{ $vehicle->VBC0 }}" required="required" type="text" class="form-control" name="VBC0" id="VBC0" maxlength="50" placeholder="Code">
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
											<input {{ ($vehicle->MSH == "1" ? "checked":"") }} name="MSH" id="MSH" type="checkbox">
											<span class="slider round"></span>
										</label>
									</div>
									
								</div>
								
								<!-- /.form-group -->
							</div>
							<!-- /.col -->
						</div>
						<div class="form-group row">
							<div class="col-sm-6">
								<div class="form-check" style="float: left !important">
									<input {{ ($vehicle->VTV == "1" ? "checked":"") }} value="1" type="checkbox" name="VTV" class="form-check-input" id="VTV">
									<label class="form-check-label text-success" for="VTV"><b>Activate Vehicle</b></label>
								</div>
							</div>
						</div>
						<div class="form-group row">
							<div class="col-md-12 text-center">
								@if($workflow == 0)
								<input id="save" required="required" class="btn btn-info" type="submit" name="submit" value="Update"/>
								@endif
								<a href="{{ route('vehicle.index') }}" class="btn btn-info">Back</a>
							</div>
						</div>	

						<!-- SELECT2 EXAMPLE -->

					</div>
					<!-- /.col -->
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
									<label for="SVE" class="col-sm-3 col-form-label">Venue</label>
									<div class="col-sm-5">
										<input maxlength="50" value="{{ $vehicle->SVE }}" type="text" class="form-control" name="SVE" id="SVE" >
									</div>
								</div>
								<div class="form-group row">
									<label for="SSD" class="col-sm-3 col-form-label">Next Scheduled Date</label>
									<div class="col-sm-2">
										<input value="{{ $vehicle->SSD }}" onkeydown="return false" type="date" class="form-control" name="SSD" id="SSD" >
									</div>

									<label for="SSM" class="col-sm-3 col-form-label">(or) Next Scheduled Mileage</label>
									<div class="col-sm-2">
										<input value="{{ $vehicle->SSM }}" maxlength="6" type="text" class="form-control number" name="SSM" id="SSM" >
									</div>
								</div>

								<div class="form-group row">
									<label for="RSS" class="col-sm-1 col-form-label">Recurring</label>
									<div class="col-sm-2" style="margin-top:10px">
										<label class="switch">
											<input {{ ($vehicle->RSS == "1" ? "checked":"") }} name="RSS" id="RSS" type="checkbox">
											<span class="slider round"></span>
										</label>
									</div>
									<label for="SMF" class="col-sm-2 col-form-label">Recurrence</label>
									<div class="col-sm-2">
										<input value="{{ $vehicle->SMF }}" type="text" maxlength="6" class="form-control number" name="SMF" id="SMF" placeholder="Every Km" >
									</div>
									<label for="SSF" class="col-sm-1 col-form-label">(or)</label>
									<div class="col-sm-2">
										<select name="SSF" id="SSF" class="custom-select">
											<option {{ ($vehicle->SSF == "Daily" ? "selected":"") }} value="Daily" >Daily</option>
											<option {{ ($vehicle->SSF == "Weekly" ? "selected":"") }} value="Weekly" >Weekly</option>
											<option {{ ($vehicle->SSF == "Monthly" ? "selected":"") }} value="Monthly" >Monthly</option>
											<option {{ ($vehicle->SSF == "Yearly" ? "selected":"") }} value="Yearly" >Yearly</option>
										</select>
									</div>
								</div>

								<div class="form-group row">
									<div class="col-sm-3">
									</div>
									<label for="SSFP" class="col-sm-2 col-form-label">Recur Every</label>
									<div class="col-sm-2">
										<input value="{{ $vehicle->SSFP }}" type="text" maxlength="2" class="form-control number" name="SSFP" id="SSFP">
									</div>

									<label for="SSFD" class="col-sm-1 col-form-label">On Day</label>
									<div class="col-sm-2">
										<select name="SSFD" id="SSFD" class="custom-select">
											<option {{ ($vehicle->SSFD == "0" ? "selected":"") }} value="0" >Sunday</option>
											<option {{ ($vehicle->SSFD == "1" ? "selected":"") }} value="1" >Monday</option>
											<option {{ ($vehicle->SSFD == "2" ? "selected":"") }} value="2" >Tuesday</option>
											<option {{ ($vehicle->SSFD == "3" ? "selected":"") }} value="3" >Wednesday</option>
											<option {{ ($vehicle->SSFD == "4" ? "selected":"") }} value="4" >Thursday</option>
											<option {{ ($vehicle->SSFD == "5" ? "selected":"") }} value="5" >Friday</option>
											<option {{ ($vehicle->SSFD == "6" ? "selected":"") }} value="6" >Saturday</option>
										</select>
									</div>
								</div>								

								<br><label>Vehicle Inspection Scheduling</label>
								<div class="form-group row">
									<label for="IVE" class="col-sm-3 col-form-label">Venue</label>
									<div class="col-sm-5">
										<input maxlength="50" value="{{ $vehicle->IVE }}" type="text" class="form-control" name="IVE" id="IVE" >
									</div>
								</div>
								<div class="form-group row">
									<label for="ISD" class="col-sm-3 col-form-label">Next Scheduled Date</label>
									<div class="col-sm-2">
										<input value="{{ $vehicle->ISD }}" onkeydown="return false" type="date" class="form-control" name="ISD" id="ISD" >
									</div>

									<label for="ISM" class="col-sm-3 col-form-label">(or) Next Scheduled Mileage</label>
									<div class="col-sm-2">
										<input value="{{ $vehicle->ISM }}" type="text" maxlength="6" class="form-control number" name="ISM" id="ISM" >
									</div>
								</div>

								<div class="form-group row">
									<label for="RIS" class="col-sm-1 col-form-label">Recurring</label>
									<div class="col-sm-2" style="margin-top:10px">
										<label class="switch ">
											<input {{ ($vehicle->RIS == "1" ? "checked":"") }} name="RIS" id="RIS" type="checkbox">
											<span class="slider round"></span>
										</label>
									</div>
									<label for="IMF" class="col-sm-2 col-form-label">Recurrence</label>
									<div class="col-sm-2">
										<input value="{{ $vehicle->IMF }}" type="text" maxlength="6" class="form-control number" name="IMF" id="IMF" placeholder="Every Km" >
									</div>
									<label for="ISF" class="col-sm-1 col-form-label">(or)</label>
									<div class="col-sm-2">
										<select name="ISF" id="ISF" class="custom-select">
											<option {{ ($vehicle->ISF == "Daily" ? "selected":"") }} value="Daily" >Daily</option>
											<option {{ ($vehicle->ISF == "Weekly" ? "selected":"") }} value="Weekly" >Weekly</option>
											<option {{ ($vehicle->ISF == "Monthly" ? "selected":"") }} value="Monthly" >Monthly</option>
											<option {{ ($vehicle->ISF == "Yearly" ? "selected":"") }} value="Yearly" >Yearly</option>
										</select>
									</div>
								</div>

								<div class="form-group row">
									<div class="col-sm-3">
									</div>
									<label for="ISFP" class="col-sm-2 col-form-label">Recur Every</label>
									<div class="col-sm-2">
										<input value="{{ $vehicle->ISFP }}" type="text" maxlength="2" class="form-control number" name="ISFP" id="ISFP">
									</div>

									<label for="ISFD" class="col-sm-1 col-form-label">On Day</label>
									<div class="col-sm-2">
										<select name="ISFD" id="ISFD" class="custom-select">
											<option {{ ($vehicle->ISFD == "0" ? "selected":"") }} value="0" >Sunday</option>
											<option {{ ($vehicle->ISFD == "1" ? "selected":"") }} value="1" >Monday</option>
											<option {{ ($vehicle->ISFD == "2" ? "selected":"") }} value="2" >Tuesday</option>
											<option {{ ($vehicle->ISFD == "3" ? "selected":"") }} value="3" >Wednesday</option>
											<option {{ ($vehicle->ISFD == "4" ? "selected":"") }} value="4" >Thursday</option>
											<option {{ ($vehicle->ISFD == "5" ? "selected":"") }} value="5" >Friday</option>
											<option {{ ($vehicle->ISFD == "6" ? "selected":"") }} value="6" >Saturday</option>
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

	function validate_all(e){
		var selection = document.getElementById('VID');
		for (var i=0; i<selection.files.length; i++) {
		    if(selection.files[i].size > 5000000){
		    	alert('Insurance file size can be a maximum of 5MB');
		        return false;
		    }
		} 
		selection = document.getElementById('VRD');
		for (var i=0; i<selection.files.length; i++) {
		    if(selection.files[i].size > 5000000){
		    	alert('Roadworthy Certificate file size can be a maximum of 5MB');
		        return false;
		    }
		} 
	}

	function readURL(input,photoprview) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              $('#'+photoprview)              
                  .attr('src', e.target.result)
                  .width(150)
                  .height(150);
          };
          reader.readAsDataURL(input.files[0]);
      }
  }
		</script>
		@endpush