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
			<form onsubmit="return validate_all(event);"  action="{{ route('vehicle.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
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
								<input onchange="readURL(this,'ins');" required="required" accept="application/pdf,image/png, image/jpeg" name="VID" type="file" id="VID">
								<img id="ins"  />
							</div>
						</div>

						<div class="form-group row">
							<label for="IEX" class="col-sm-4 col-form-label"><span style="color:red">*</span>Insurance Expiry Date</label>
							<div class="col-sm-5">
								<input min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required="required" onkeydown="return false" type="date" class="form-control" name="IEX" id="IEX" >
							</div>
							
								<label class="col-form-label">Reminder</label>&nbsp;
								<label class="switch" style="margin-top:10px">
									<input name="AVI" id="AVI" type="checkbox">
									<span class="slider round"></span>
								</label>
							</div>
						<div class="form-group row">
							<label for="VRD" class="col-sm-4 col-form-label"><span style="color:red">*</span>Roadworthy Cert<br>&nbsp;File Type (pdf/jpg/png)</label>
							<div class="col-sm-8">
								<input onchange="readURL(this,'rdw');" required="required" accept="application/pdf,image/png, image/jpeg" name="VRD" type="file" id="VRD">
								<img id="rdw"  />
							</div>
						</div>

						<div class="form-group row">
							<label for="REX" class="col-sm-4 col-form-label"><span style="color:red">*</span>Roadworthy Expiry Date</label>
							<div class="col-sm-5">
								<input min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required="required" onkeydown="return false" type="date" class="form-control" name="REX" id="REX" >
							</div>
								<label class="col-form-label">Reminder</label>&nbsp;
								<label class="switch"style="margin-top:10px">
									<input name="AVR" id="AVR" type="checkbox">
									<span class="slider round"></span>
								</label>
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
						<div class="form-group row">
							<label for="chassis_no" class="col-sm-4 col-form-label"><span style="color:red"></span>Vehicle Chassis No</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="chassis_no" id="chassis_no" maxlength="30" placeholder="Vehicle Chassis No">
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
												<input type="text" class="form-control decimal" name="ECY" id="ECY" maxlength="10" placeholder="Engine Capacity">
											</div>
										</div>
										<div class="form-group row">
											<label for="VFT" class="col-sm-4 col-form-label"><span style="color:red">*</span>RH – Tank Capacity (Litres)</label>
											<div class="col-sm-8">
												<input type="text" class="form-control decimal" name="VFT" id="VFT" maxlength="10" placeholder="Tank Capacity">
											</div>
										</div>
										<div class="form-group row">
											<label for="VFC" class="col-sm-4 col-form-label"><span style="color:red">*</span>RH – Fueling Cap (Litres)</label>
											<div class="col-sm-8">
												<input type="text" class="form-control decimal" name="VFC" id="VFC" maxlength="10" placeholder="Fueling Cap (%)">
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
												<input onkeyup="duplicateDeviceSN(0)" type="text" class="form-control" name="TSN" id="TSN" maxlength="50" placeholder="Tracker Device SN">
												<span id="dupTSN" style="color:red"></span>
											</div>
										</div>
										<div class="form-group row">
											<label for="TID" class="col-sm-4 col-form-label"><span style="color:red">*</span>Tracker ID</label>
											<div class="col-sm-8">
												<input onkeyup="duplicateTrackerID(0)" type="text" class="form-control" name="TID" id="TID" maxlength="50" placeholder="Tracker ID">
												<span id="dupTID" style="color:red"></span>
											</div>
										</div>
										<div class="form-group row">
											<label for="TSM" class="col-sm-4 col-form-label"><span style="color:red">*</span>Tracker SIM No.</label>
											<div class="col-sm-8">
												<input onkeyup="duplicateTrackerSIM(0)" type="text" class="form-control" name="TSM" id="TSM" maxlength="50" placeholder="Tracker SIM No.">
												<span id="dupTSM" style="color:red"></span>
											</div>
										</div>
										<div class="form-group row">
											<label for="TIP" class="col-sm-4 col-form-label"><span style="color:red"></span>Terminal IP Address</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" name="TIP" id="TIP" maxlength="50" placeholder="Terminal IP Address">
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<!-- text input -->
												<div class="form-group row">
													<label for="VZC1" class="col-sm-6 col-form-label"><span style="color:red">*</span>Buzzer (On)</label>
													<div class="col-sm-6">
														<input type="text" class="form-control" name="VZC1" id="VZC1" maxlength="50" placeholder="Code">
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group row">
													<label for="VZC0" class="col-sm-6 col-form-label"><span style="color:red">*</span>Buzzer (Off)</label>
													<div class="col-sm-6">
														<input type="text" class="form-control" name="VZC0" id="VZC0" maxlength="50" placeholder="Code">
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
														<input type="text" class="form-control" name="VBC1" id="VBC1" maxlength="50" placeholder="Code">
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group row">
													<label for="VBC0" class="col-sm-6 col-form-label"><span style="color:red">*</span>Blocking (Off):</label>
													<div class="col-sm-6">
														<input type="text" class="form-control" name="VBC0" id="VBC0" maxlength="50" placeholder="Code">
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
						<a href="{{ url('allvehicle/1') }}" class="btn btn-info">Back</a>
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
							<label for="SVE" class="col-sm-3 col-form-label">Venue</label>
							<div class="col-sm-5">
								<input maxlength="50" type="text" class="form-control" name="SVE" id="SVE" >
							</div>
						</div>
						<div class="form-group row">
							<label for="SSD" class="col-sm-3 col-form-label">Next Scheduled Date</label>
							<div class="col-sm-2">
								<input value="{{ date('Y-m-d') }}" onkeydown="return false" type="date" class="form-control" name="SSD" id="SSD" >
							</div>

							<label for="SSM" class="col-sm-1 col-form-label text-center">(OR)</label><label for="SSM" class="col-sm-3 col-form-label">Next Scheduled Mileage</label>
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
							<div class="col-sm-1">
								<input type="text" maxlength="6" class="form-control number" name="SMF" id="SMF" placeholder="EveryKm" >
							</div>
							<label for="SSF" class="col-sm-1 col-form-label text-center">(OR)</label>
							<label for="SSF" class="col-sm-3 col-form-label">Recur Every (Month)</label>
							<div class="col-sm-1">
								<input type="text" maxlength="2" class="form-control number" name="SSFP" id="SSFP">
							</div>
						</div>							

						<br><label>Vehicle Inspection Scheduling</label>
						<div class="form-group row">
							<label for="IVE" class="col-sm-3 col-form-label">Venue</label>
							<div class="col-sm-5">
								<input maxlength="50" type="text" class="form-control" name="IVE" id="IVE" >
							</div>
						</div>
						<div class="form-group row">
							<label for="ISD" class="col-sm-3 col-form-label">Next Scheduled Date</label>
							<div class="col-sm-2">
								<input value="{{ date('Y-m-d') }}" onkeydown="return false" type="date" class="form-control" name="ISD" id="ISD" >
							</div>
                            <label for="ISM" class="col-sm-1 col-form-label text-center">(OR)</label>
							<label for="ISM" class="col-sm-3 col-form-label">Next Scheduled Mileage</label>
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
							<div class="col-sm-1">
								<input type="text" maxlength="6" class="form-control number" name="IMF" id="IMF" placeholder="EveryKm" >
							</div>
							<label for="ISF" class="col-sm-1 col-form-label text-center">(OR)</label>
							<label for="ISF" class="col-sm-3 col-form-label">Recur Every (Month)</label>

							<div class="col-sm-1">
								<input type="text" maxlength="2" class="form-control number" name="ISFP" id="ISFP">
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
			var ECY = $("#ECY").val().trim();
		    if(ECY == ""){
		    	alert('Please enter Engine Capacity');
		        return false;
		    }
		    var VFT = $("#VFT").val().trim();
		    if(VFT == ""){
		    	alert('Please enter Tank Capacity');
		        return false;
		    }
		    var VFC = $("#VFC").val().trim();
		    if(VFC == ""){
		    	alert('Please enter Fueling Cap');
		        return false;
		    }
		    var TSN = $("#TSN").val().trim();
		    if(TSN == ""){
		    	alert('Please enter Tracker Device SN');
		        return false;
		    }
		    var TID = $("#TID").val().trim();
		    if(TID == ""){
		    	alert('Please enter Tracker ID');
		        return false;
		    }
		    var TSM = $("#TSM").val().trim();
		    if(TSM == ""){
		    	alert('Please enter Tracker SIM No');
		        return false;
		    }
		    var VZC1 = $("#VZC1").val().trim();
		    if(VZC1 == ""){
		    	alert('Please enter Buzzer (On)');
		        return false;
		    }
		    var VZC0 = $("#VZC0").val().trim();
		    if(VZC0 == ""){
		    	alert('Please enter Buzzer (Off)');
		        return false;
		    }
		    var VBC1 = $("#VBC1").val().trim();
		    if(VBC1 == ""){
		    	alert('Please enter Blocking (On)');
		        return false;
		    }
		    var VBC0 = $("#VBC0").val().trim();
		    if(VBC0 == ""){
		    	alert('Please enter Blocking (Off)');
		        return false;
		    }

		    var MSH = $("#MSH").is(':checked') ? 1 : 0; 
		    if(MSH == 1){
				var SSM = $("#SSM").val().trim();
				if(SSM == ""){
		    		alert('Please enter next scheduled service mileage');
		        	return false;
		    	}
		    	var ISM = $("#ISM").val().trim();
				if(ISM == ""){
		    		alert('Please enter next scheduled inspection mileage');
		        	return false;
		    	}
		    	var RSS = $("#RSS").is(':checked') ? 1 : 0;
		    	if(RSS == 1){
		    		var SMF = $("#SMF").val().trim();
					if(SMF == ""){
			    		alert('Please enter service recurrence Km');
			        	return false;
			    	}
			    	var SSFP = $("#SSFP").val().trim();
					if(SSFP == ""){
			    		alert('Please enter service recurrence months');
			        	return false;
			    	}
		    	}
		    	var RIS = $("#RIS").is(':checked') ? 1 : 0;
		    	if(RIS == 1){
		    		var IMF = $("#IMF").val().trim();
					if(IMF == ""){
			    		alert('Please enter inspection recurrence Km');
			        	return false;
			    	}
			    	var ISFP = $("#ISFP").val().trim();
					if(ISFP == ""){
			    		alert('Please enter inspection recurrence months');
			        	return false;
			    	}
		    	}
		    }

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