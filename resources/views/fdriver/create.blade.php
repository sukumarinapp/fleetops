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
                <form onsubmit="return validate_all(event);" action="{{ route('fdriver.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
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
					<label for="DLD" class="col-sm-4 col-form-label"><span style="color:red"></span>License Front</label>
					<div class="col-sm-8">
             <input onchange="readURL(this,'lic');" accept="image/png, image/jpeg" required="required" name="DLD" type="file" id="DLD">
             <img id="lic"  />
					</div>
				</div>

        <div class="form-group row">
					<label for="DLD2" class="col-sm-4 col-form-label"><span style="color:red"></span>License Back</label>
					<div class="col-sm-8">
              <input onchange="readURL(this,'lic2');" accept="image/png, image/jpeg" required="required" name="DLD2" type="file" id="DLD2">
              <img id="lic2"  />
					</div>
				</div>

				<div class="form-group row">
										<label for="LEX" class="col-sm-4 col-form-label"><span style="color:red">*</span>License Expiry Date</label>
										<div class="col-sm-5">
											<input required="required" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" onkeydown="return false" type="date" class="form-control" name="LEX" id="LEX" >
										</div>
											<label class="col-form-label">Reminder</label>&nbsp;
											<label class="switch" style="margin-top:10px">
												<input name="AVL" id="AVL" type="checkbox">
												<span class="slider round"></span>
											</label>
									</div>

                <div class="form-group row">
					<label for="VCC" class="col-sm-4 col-form-label"><span style="color:red"></span>Contract</label>
					<div class="col-sm-8">
                        <input accept="application/pdf" required="required" name="VCC" type="file" id="VCC">
					</div>
				</div>
				<div class="form-group row">
										<label for="CEX" class="col-sm-4 col-form-label"><span style="color:red">*</span>Contract Expiry Date</label>
										<div class="col-5">
											<input required="required" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" onkeydown="return false" type="date" class="form-control" name="CEX" id="CEX" >
										</div>
											<label class="col-form-label">Reminder</label>&nbsp;
											<label class="switch" style="margin-top:10px">
												<input name="AVC" id="AVC" type="checkbox">
												<span class="slider round"></span>
											</label>
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
											<input type="text" readonly class="form-control" name="VPL" id="VPL" maxlength="50" placeholder="location">
										</div>
											<div class="col-sm-1">
		<button type="button" class="btn btn-primary btn-sm btn-block"  data-toggle="modal" data-target="#myMapModal" ><i class="nav-icon fa fa-map-marker"></i></button>
		</div>
	</div>
	<div class="form-group row">
	<label class="col-sm-4 col-form-label"></label>
	<div class="col-sm-4">
		<button type="button" onclick="getcurrentLocation()" class="btn btn-primary btn-sm btn-block ">Get Current Location</button>
	</div>
</div>
		<div class="modal fade" id="myMapModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Parking Location<br>Click on a location and Confirm</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="map-canvas" style="height: 400px;"></div>
      </div>
      <div class="modal-footer">
        <button id="confirm_btn" onclick="get_location()" type="button" class="btn btn-primary" data-dismiss="modal">Confirm</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
									</div>
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

              <div class="form-group row">
							<button type="button" class="btn btn-outline-primary float-right" data-toggle="modal" data-target="#RH-Fuel"><i class="nav-icon fas fa-cog"></i>Schedule Invoicing
							</button>
						</div>

						<div class="modal fade" id="RH-Fuel">
							<div class="modal-dialog modal-xl">
								<div class="modal-content">
									<div class="modal-header">
										<h6 class="modal-title">Schedule Invoicing</h6>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">

													
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
           <div class="col-md-12" id="Business">
             <div class="form-group row">
             	<label for="PLF" class="col-sm-4 col-form-label">1. Driver Status:</label>
             </div>
              <div class="form-group row">
             <div class="col-sm-8">
             		<label class="col-sm-1 col-form-label"></label>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input checked="checked" value="employee" type="radio" class="form-check-input" name="driver_status">Employee
											</label>
										</div>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" value="contractor" class="form-check-input" name="driver_status">Independent Contractor
											</label>
										</div>
									</div>
								</div>

              <div class="form-group row">
             	<label for="PLF" class="col-sm-4 col-form-label">2. Principal Earning:</label>
             </div> 
          <div class="form-group row">
          	<label class="col-sm-1 col-form-label"></label>
          	<div class="form-check-inline col-sm-3 ">
											<label class="form-check-label">
												<input checked="checked" value="fixed" type="radio" class="form-check-input" name="earning_type">Fixed Earning
											</label>
										</div>
					
					<div class="col-sm-3">
						 <input type="text" class="form-control decimal" name="FPE" id="FPE" maxlength="10" placeholder="Fixed Amount">
					</div>
				</div>  
				       <div class="form-group row">
          	<label class="col-sm-1 col-form-label"></label>
          	<div class="form-check-inline col-sm-3">
											<label class="form-check-label ">
												<input type="radio" value="performance" class="form-check-input" name="earning_type">Performance Based Earning
											</label>
										</div>
				
					<div class="col-sm-3">
						 <input type="text" class="form-control decimal" name="PPE" id="PPE" maxlength="10" placeholder="Percent">
					</div>
				</div>
             <div class="col-sm-8">
             		<label class="col-sm-6 col-form-label"></label>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" checked="checked" value="sales" class="form-check-input" name="PPE_TYPE">???of Total Sales
											</label>
										</div>
									</div>
									<div class="col-sm-8">
             		<label class="col-sm-6 col-form-label"></label>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" value="earning" class="form-check-input" name="PPE_TYPE">...of Net of Earning
											</label>
										</div>
									</div>
           <div class="form-group row">
             	<label for="PLF" class="col-sm-4 col-form-label">3. Performance Bonus:</label>
             </div> 
              <div class="form-group row">
          	<label class="col-sm-1 col-form-label"></label>
          	<div class="form-check-inline col-sm-4 ">
											<label class="form-check-label">
												<input type="checkbox" class="form-check-input" name="bonus">Performance in excess of achieved target
											</label>
										</div>
					
					<div class="col-sm-4">
						 <div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" checked="checked" value="sales" class="form-check-input" name="bonus_type">???of Total Sales
											</label>
										</div>
					</div>

          	<div class="form-check-inline col-sm-5 ">
										</div>
					<div class="col-sm-4">
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" value="earning" class="form-check-input" name="bonus_type">...of Net of Earning
											</label>
										</div>
									</div>
				   </div>

	<div class="form-group row">
		<label class="col-sm-1 col-form-label"></label>
					<label for="PBT" class="col-sm-2 col-form-label">Target amount:</label>
					<div class="col-sm-3">
						 <input type="text" class="form-control decimal" name="PBT" id="PBT" maxlength="10" placeholder="Target Amount">
					</div>
				</div>

    <div class="form-group row">
		<label class="col-sm-1 col-form-label"></label>
					<label for="PBP" class="col-sm-2 col-form-label">Percentage rewarded:</label>
					<div class="col-sm-3">
						 <input type="text" class="form-control decimal" name="PBP" id="PBP" maxlength="10" placeholder="Percent">
					</div>
				</div>

				 <div class="form-group row">
             	<label for="EPF" class="col-sm-3 col-form-label">4. Earning Payment Frequency:</label>
            
             <div class="col-sm-4">
						 <select name="EPF" id="EPF" class="custom-select">
                         <option value="Daily" selected="selected">Daily</option>
                         <option value="Weekly" >Weekly</option>
                         <option value="Monthly" >Monthly</option>
                        </select>
					</div>
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
                    <label  class="form-check-label col-sm-5" for="EPD"><b>Enable Penalty Rule on Payment Defaults</b></label>
                     <div class="icheck-success d-inline col-sm-1">
                        <input name="EPD" type="checkbox" id="EPD">
                    </div> 
				</div>

				<div class="form-group row" id="def" style="display: none;">
										<label for="NOD" class="col-sm-5 col-form-label"><span style="color:red"></span>Total Number of Defaults Allowed</label>
										<div class="col-2">
											<input maxlength="2" type="text" class="form-control number" name="NOD" id="NOD" >
										</div>
									</div>

										<div class="form-group row" id="pen" style="display: none;">
										<label for="PAM" class="col-sm-5 col-form-label">Penalty Amount:</label>
										<div class="col-2">
											<input maxlength="5" type="text" class="form-control number" name="PAM" id="PAM" >
										</div>
										
											<label for="CEX" class="col-sm-1 col-form-label">per</label>
										<div class="col-sm-2">
						 <select name="PAT" id="PAT" class="custom-select">
               <option value="Daily" >Daily</option>
              </select>
					</div>
									</div>

									<div class="form-group row" id="due" style="display: none;">
										<p class="col-form-label">The total aggregated sum of penalty amount charged at stated frequency shall be added to next payment due.</p>
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
$('#myMapModal').on('shown.bs.modal', function(e) {
	$("#confirm_btn").attr("disabled", true);
	VPL = $("#VPL").val();
  if(VPL == ""){
  	initialize(new google.maps.LatLng("5.605884551566098","-0.19313015133623626"));
  }else{
  	var data = VPL.split(',')
	initialize(new google.maps.LatLng(data[0], data[1]));
  }
});

var lat = "";
var lng = "";
var map;
function initialize(myCenter) {
	var marker = new google.maps.Marker({
	  position: myCenter
	});
	var mapProp = {
	  center: myCenter,
	  zoom: 14,
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById("map-canvas"), mapProp);
	marker.setMap(map);

	google.maps.event.addListener(map, "click", function (event) {
      var myLatLng = event.latLng;
	    lat = myLatLng.lat();
	    lng = myLatLng.lng();
	    $("#confirm_btn").removeAttr("disabled");
    });
}

function get_location(){
	if(lat != "") $("#VPL").val(lat+","+lng);
}

function showLocation(position) {
	var latitude = position.coords.latitude;
	var longitude = position.coords.longitude;
	$("#VPL").val(latitude+","+longitude);
	//alert("Latitude : " + latitude + " Longitude: " + longitude);
}

function errorHandler(err) {
	if(err.code == 1) {
	   alert("Error: Access is denied!");
	} else if( err.code == 2) {
	   alert("Error: Position is unavailable!");
	}
}
      
function getcurrentLocation() {
	if(navigator.geolocation) {
	   // timeout at 60000 milliseconds (60 seconds)
	   var options = {timeout:60000};
	   navigator.geolocation.getCurrentPosition(showLocation, errorHandler, options);
	} else {
	   alert("Sorry, browser does not support geolocation!");
	}
}

jQuery(document).ready(function($) {
	$("#penalty").hide("slow");
  $("#def").hide("slow");
  $("#pen").hide("slow");
  $("#due").hide("slow");
  VPL = $("#VPL").val();
  if(VPL == ""){
  	getcurrentLocation();
  }
});

  function validate_all(e){
  	if($("#VBM").val()!="Ride Hailing"){
        if($("#VPD").val().trim() == ""){
            alert("Enter payment date");
            $("#VPD").focus();
            return false;
        }
        if($("#VAM").val().trim() == ""){
            alert("Enter payment amount");
            $("#VAM").focus();
            return false;
        }
    }
		var selection = document.getElementById('DLD');
		for (var i=0; i<selection.files.length; i++) {
		    if(selection.files[i].size > 5000000){
		    	alert('Licence front file size can be a maximum of 5MB');
		        return false;
		    }
		} 
		selection = document.getElementById('DLD2');
		for (var i=0; i<selection.files.length; i++) {
		    if(selection.files[i].size > 5000000){
		    	alert('Licence back file size can be a maximum of 5MB');
		        return false;
		    }
		} 
    selection = document.getElementById('VCC');
		for (var i=0; i<selection.files.length; i++) {
		    if(selection.files[i].size > 5000000){
		    	alert('Contract file size can be a maximum of 5MB');
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
@endsection