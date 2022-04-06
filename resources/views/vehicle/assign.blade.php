@extends('layouts.app')
@section('content')
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
              <li class="breadcrumb-item">Assign Vehicle</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Assign Vehicle</h3>
				</div>
          	<div class="card-body">
          		<form method="post" action="{{ route('assigndriver') }}">
      			@csrf
      			<input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

			<div class="card-body" style="overflow-x: auto;" >
				<table class="table table-bordered">
          <thead>
          <tr>
            <th>CAN</th>
            <th>Name</th>
            <th>Assigned Vehicle</th>
            <th>Make</th>
            <th>Model</th>
            <th>Color</th>
          </tr>
          </thead>
          <tbody>
          	<tr>
          		<td>{{ $vehicle->CAN }}</td>
          		<td>{{ $vehicle->name }}</td>
          		<td>{{ $vehicle->VNO }}</td>
          		<td>{{ $vehicle->VMK }}</td>
          		<td>{{ $vehicle->VMD }}</td>
          		<td>{{ $vehicle->VCL }}</td>
          	</tr>
          </tbody>
        </table>
				
				<div class="form-group row">
					<div class="col-md-12">
						<label for="DNM" class="col-form-label"><span style="color:red">*</span>Please Select Driver to Assign Vehicle:</label>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-12">
						<select style="width: 100%;" required="required" class="form-control select2" name="driver_id" id="driver_id" >
							<option value="">Search Driver</option>
	                        @foreach($drivers as $driver)
		                     	<option value="{{ $driver->id }}" >{{ $driver->DNM }} {{ $driver->DSN }} -  {{ $driver->DNO }} - {{ $driver->DCN }}</option>
		                    @endforeach
	                    </select>
                	</div>
				</div>
<!-- <div class="col-md-12">
				<div class="row mb-4">
<div class="col-sm-6">
  <h6 class="mb-3"></h6>
<div><strong>Date : </strong> <span>{{ date("l M d Y")}}</span></div>
<div><strong>Customer : </strong> <span></span></div>
<div><strong>Address : </strong> <span>Accra</span></div>
</div>

</div>
<div class="col-6 text-center d-flex align-items-center justify-content-center">
              <div class="card-body">
                <h4 style=" border: 1px solid grey;padding: 25px 25px 25px 25px;"></h4>
                <br>
        </div>
      </div>
      </div> -->
    </div>
                <div class="card-body row">
             
               <div class="col-md-5">
           <div class="form-group row">
							<label for="VMD" class="col-sm-5 col-form-label"><span style="color:red"></span>Vehicle Reg. No.:</label>
							<div class="col-sm-4" style="margin-top:8px">
								GN7119-17
							</div>
						</div>  
						<div class="form-group row">
							<label for="VMD" class="col-sm-5 col-form-label"><span style="color:red"></span>Vehicle Chassis No.:</label>
							<div class="col-sm-4" style="margin-top:8px">
								E556807VU65546
							</div>
						</div> 
						 <div class="form-group row">
							<label for="VMD" class="col-sm-5 col-form-label"><span style="color:red"></span>Insurance Expiry Date:</label>
							<div class="col-sm-4" style="margin-top:8px">
								26-09-2023
							</div>
						</div>  
						<div class="form-group row">
							<label for="VMD" class="col-sm-5 col-form-label"><span style="color:red"></span>Roadworthy Expiry Date:</label>
							<div class="col-sm-4" style="margin-top:8px">
								26-09-2023
							</div>
						</div>
					</div>
					 <div class="col-md-2 text-right d-flex align-items-right justify-content-center">
             <img class="img-fluid img-thumbnail" src="{{ URL::to('/') }}/images/test.jpg" style="width:70%;height:80%"> 
      </div>
      <div class="col-md-5 text-right d-flex align-items-right justify-content-center">
              <div class="card-body">
                <div style=" border: 1px solid grey;padding: 10px 10px 10px 10px;">
                	<div class="form-group row">
					<div class="col-md-12">
						<select style="width: 100%;" required="required" class="form-control select2" name="driver_id" id="driver_id" >
							<option value="">Search Driver</option>
	                        @foreach($drivers as $driver)
		                     	<option value="{{ $driver->id }}" >{{ $driver->DNM }} {{ $driver->DSN }} -  {{ $driver->DNO }} - {{ $driver->DCN }}</option>
		                    @endforeach
	                    </select>
                	</div>
				</div>

                </div>
        </div>
      </div>
<div class="col-md-12">
						<div class="form-group row">
							<label for="VMD" class="col-sm-3 col-form-label"><span style="color:red">*</span>Starting Mileage</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" name="VMD" id="VMD" maxlength="50" placeholder="">
							</div>
						</div>
						<div class="form-group row">
							<label for="VMD" class="col-sm-3 col-form-label"><span style="color:red">*</span>Spare Tire</label>
							<div class="col-sm-2">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input checked="checked" value="1" type="radio" class="form-check-input" name="VI01" >Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI01" >No
									</label>
								</div>
							</div>
							<div class="col-sm-4">
								<input type="text" class="form-control form-control-sm" name="CI01" id="CI01" maxlength="20">
							</div>
						</div>
						<div class="form-group row">
							<label for="VMD" class="col-sm-3 col-form-label"><span style="color:red">*</span>Warning Triangle</label>
														<div class="col-sm-2">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input checked="checked" value="1" type="radio" class="form-check-input" name="VI01" >Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI01" >No
									</label>
								</div>
							</div>
							<div class="col-sm-4">
								<input type="text" class="form-control form-control-sm" name="CI01" id="CI01" maxlength="20">
							</div>
						</div>
						<div class="form-group row">
							<label for="VMD" class="col-sm-3 col-form-label"><span style="color:red">*</span>Vehicle Tools</label>
														<div class="col-sm-2">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input checked="checked" value="1" type="radio" class="form-check-input" name="VI01" >Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI01" >No
									</label>
								</div>
							</div>
							<div class="col-sm-4">
								<input type="text" class="form-control form-control-sm" name="CI01" id="CI01" maxlength="20">
							</div>
						</div>
						<div class="form-group row">
							<label for="VMD" class="col-sm-3 col-form-label"><span style="color:red">*</span>Fire Extinguisher</label>
														<div class="col-sm-2">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input checked="checked" value="1" type="radio" class="form-check-input" name="VI01" >Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI01" >No
									</label>
								</div>
							</div>
							<div class="col-sm-4">
								<input type="text" class="form-control form-control-sm" name="CI01" id="CI01" maxlength="20">
							</div>
						</div>
						<div class="form-group row">
							<label for="VMD" class="col-sm-3 col-form-label"><span style="color:red">*</span>Front Lights (Deem) L/R</label>
														<div class="col-sm-2">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input checked="checked" value="1" type="radio" class="form-check-input" name="VI01" >Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI01" >No
									</label>
								</div>
							</div>
							<div class="col-sm-4">
								<input type="text" class="form-control form-control-sm" name="CI01" id="CI01" maxlength="20">
							</div>
						</div>
						<div class="form-group row">
							<label for="VMD" class="col-sm-3 col-form-label"><span style="color:red">*</span>Front Lights (High) L/R</label>
														<div class="col-sm-2">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input checked="checked" value="1" type="radio" class="form-check-input" name="VI01" >Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI01" >No
									</label>
								</div>
							</div>
							<div class="col-sm-4">
								<input type="text" class="form-control form-control-sm" name="CI01" id="CI01" maxlength="20">
							</div>
						</div>
						<div class="form-group row">
							<label for="VMD" class="col-sm-3 col-form-label"><span style="color:red">*</span>Indicator Lights (FL/FR/RL/RR)</label>
														<div class="col-sm-2">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input checked="checked" value="1" type="radio" class="form-check-input" name="VI01" >Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI01" >No
									</label>
								</div>
							</div>
							<div class="col-sm-4">
								<input type="text" class="form-control form-control-sm" name="CI01" id="CI01" maxlength="20">
							</div>
						</div>
												<div class="form-group row">
							<label for="VMD" class="col-sm-3 col-form-label"><span style="color:red">*</span>Parking Lights L/R</label>
														<div class="col-sm-2">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input checked="checked" value="1" type="radio" class="form-check-input" name="VI01" >Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI01" >No
									</label>
								</div>
							</div>
							<div class="col-sm-4">
								<input type="text" class="form-control form-control-sm" name="CI01" id="CI01" maxlength="20">
							</div>
						</div>
												<div class="form-group row">
							<label for="VMD" class="col-sm-3 col-form-label"><span style="color:red">*</span>Brake Lights L/R</label>
														<div class="col-sm-2">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input checked="checked" value="1" type="radio" class="form-check-input" name="VI01" >Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI01" >No
									</label>
								</div>
							</div>
							<div class="col-sm-4">
								<input type="text" class="form-control form-control-sm" name="CI01" id="CI01" maxlength="20">
							</div>
						</div>
												<div class="form-group row">
							<label for="VMD" class="col-sm-3 col-form-label"><span style="color:red">*</span>Reverse Lights L/R</label>
														<div class="col-sm-2">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input checked="checked" value="1" type="radio" class="form-check-input" name="VI01" >Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI01" >No
									</label>
								</div>
							</div>
							<div class="col-sm-4">
								<input type="text" class="form-control form-control-sm" name="CI01" id="CI01" maxlength="20">
							</div>
						</div>
												<div class="form-group row">
							<label for="VMD" class="col-sm-3 col-form-label"><span style="color:red">*</span>Wiper Function</label>
														<div class="col-sm-2">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input checked="checked" value="1" type="radio" class="form-check-input" name="VI01" >Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI01" >No
									</label>
								</div>
							</div>
							<div class="col-sm-4">
								<input type="text" class="form-control form-control-sm" name="CI01" id="CI01" maxlength="20">
							</div>
						</div>
												<div class="form-group row">
							<label for="VMD" class="col-sm-3 col-form-label"><span style="color:red">*</span>Horn</label>
														<div class="col-sm-2">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input checked="checked" value="1" type="radio" class="form-check-input" name="VI01" >Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI01" >No
									</label>
								</div>
							</div>
							<div class="col-sm-4">
								<input type="text" class="form-control form-control-sm" name="CI01" id="CI01" maxlength="20">
							</div>
						</div>
												<div class="form-group row">
							<label for="VMD" class="col-sm-3 col-form-label"><span style="color:red">*</span>Air-Conditioner</label>
														<div class="col-sm-2">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input checked="checked" value="1" type="radio" class="form-check-input" name="VI01" >Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI01" >No
									</label>
								</div>
							</div>
							<div class="col-sm-4">
								<input type="text" class="form-control form-control-sm" name="CI01" id="CI01" maxlength="20">
							</div>
						</div>
												<div class="form-group row">
							<label for="VMD" class="col-sm-3 col-form-label"><span style="color:red">*</span>Radio</label>
														<div class="col-sm-2">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input checked="checked" value="1" type="radio" class="form-check-input" name="VI01" >Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI01" >No
									</label>
								</div>
							</div>
							<div class="col-sm-4">
								<input type="text" class="form-control form-control-sm" name="CI01" id="CI01" maxlength="20">
							</div>
						</div>
												<div class="form-group row">
							<label for="VMD" class="col-sm-3 col-form-label"><span style="color:red">*</span>Wheel Caps (FL/FR/RL/RR</label>
														<div class="col-sm-2">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input checked="checked" value="1" type="radio" class="form-check-input" name="VI01" >Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI01" >No
									</label>
								</div>
							</div>
							<div class="col-sm-4">
								<input type="text" class="form-control form-control-sm" name="CI01" id="CI01" maxlength="20">
							</div>
						</div>
												<div class="form-group row">
							<label for="VMD" class="col-sm-3 col-form-label"><span style="color:red">*</span>Road Test</label>
														<div class="col-sm-2">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input checked="checked" value="1" type="radio" class="form-check-input" name="VI01" >Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI01" >No
									</label>
								</div>
							</div>
							<div class="col-sm-4">
								<input type="text" class="form-control form-control-sm" name="CI01" id="CI01" maxlength="20">
							</div>
						</div>
												<div class="form-group row">
							<label for="VMD" class="col-sm-3 col-form-label"><span style="color:red">*</span>Comments</label>
							<div class="col-sm-6">
								<input type="text" class="form-control form-control-sm" name="CI01" id="CI01" maxlength="20">
							</div>
						</div>

												<div class="form-group row">
							<label for="VRD" class="col-sm-3 col-form-label"><span style="color:red">*</span>FRONT</label>
							<div class="col-sm-6">
								<input required="required" accept="image/png, image/jpeg" name="VRD" type="file" id="VRD">
							</div>
						</div>
						<div class="form-group row">
							<label for="VRD" class="col-sm-3 col-form-label"><span style="color:red">*</span>RIGHT</label>
							<div class="col-sm-6">
								<input required="required" accept="image/png, image/jpeg" name="VRD" type="file" id="VRD">
							</div>
						</div>
						<div class="form-group row">
							<label for="VRD" class="col-sm-3 col-form-label"><span style="color:red">*</span>REAR</label>
							<div class="col-sm-6">
								<input required="required" accept="image/png, image/jpeg" name="VRD" type="file" id="VRD">
							</div>
						</div>
						<div class="form-group row">
							<label for="VRD" class="col-sm-3 col-form-label"><span style="color:red">*</span>LEFT</label>
							<div class="col-sm-6">
								<input required="required" accept="image/png, image/jpeg" name="VRD" type="file" id="VRD">
							</div>
						</div>
					</div>
           
    </div>

				<div class="form-group row">
					<div class="col-md-12 text-center">
						<input required="required" class="btn btn-info"
						type="submit"
						name="submit" value="Save"/>
                        <a href="{{ route('vehicle.index') }}" class="btn btn-info">Back</a>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
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