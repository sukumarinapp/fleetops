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
              <li class="breadcrumb-item">Unassign Vehicle</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Unassign Vehicle</h3>
				</div>
				
          	<div class="card-body">
          		<form onsubmit="return validate_all(event)" action="{{ route('removedriver') }}" method="post" class="form-horizontal" enctype="multipart/form-data">
                @csrf

                 <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
			<div class="card-body" style="overflow-x: auto;" >
				
                <div class="row">
             
               <div class="col-md-6">
           <div class="form-group row">
              <label for="VMD" class="col-sm-5 col-form-label"><span style="color:red"></span>Vehicle Reg. No.:</label>
              <div class="col-sm-4" style="margin-top:8px">
               {{ $vehicle->VNO }}
              </div>
            </div>  
            <div class="form-group row">
              <label for="VMD" class="col-sm-5 col-form-label"><span style="color:red"></span>Vehicle Chassis No.:</label>
              <div class="col-sm-4" style="margin-top:8px">
               {{ $vehicle->chassis_no }}
              </div>
            </div> 
             <div class="form-group row">
              <label for="VMD" class="col-sm-5 col-form-label"><span style="color:red"></span>Insurance Expiry Date:</label>
              <div class="col-sm-4" style="margin-top:8px">
                {{ $vehicle->IEX }}
              </div>
            </div>  
            <div class="form-group row">
              <label for="VMD" class="col-sm-5 col-form-label"><span style="color:red"></span>Roadworthy Cert Expiry Date:</label>
              <div class="col-sm-4" style="margin-top:8px">
                {{ $vehicle->REX }}
              </div>
            </div>
          </div>
           <div class="col-md-2 text-right d-flex align-items-right justify-content-center">
             <img class="img-fluid img-thumbnail" src="../uploads/photo/{{ $photo }}" style="width:70%;height:80%"> 
      </div>
      <div class="col-md-3 text-right d-flex align-items-right justify-content-center">
              <div class="card-body">
                <h6 style="text-align: center; border: 1px solid grey;padding: 25px 25px 25px 25px;">{{ $vehicle->DNM }} {{ $vehicle->DSN }}</h6>
        </div>
      </div>
          <div class="col-md-12">
            <div class="form-group row">
              <label for="CF01" class="col-sm-3 col-form-label"><span style="color:red">*</span>Ending Mileage</label>
              <div class="col-sm-6">
                <input type="text" required="required" class="form-control number" name="CF01" id="CF01" maxlength="10" placeholder="">
              </div>
            </div>
            <div class="form-group row">
              <label for="CF02" class="col-sm-3 col-form-label"><span style="color:red">*</span>Spare Tire</label>
              <div class="col-sm-2">
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input checked="checked" value="1" type="radio" class="form-check-input" name="CF02" >Yes
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input value="0" type="radio" class="form-check-input" name="CF02" >No
                  </label>
                </div>
              </div>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" name="CC01" id="CC01" maxlength="20">
              </div>
            </div>
            <div class="form-group row">
              <label for="CF03" class="col-sm-3 col-form-label"><span style="color:red">*</span>Warning Triangle</label>
                            <div class="col-sm-2">
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input checked="checked" value="1" type="radio" class="form-check-input" name="CF03" >Yes
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input value="0" type="radio" class="form-check-input" name="CF03" >No
                  </label>
                </div>
              </div>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" name="CC02" id="CC02" maxlength="20">
              </div>
            </div>
            <div class="form-group row">
              <label for="CF04" class="col-sm-3 col-form-label"><span style="color:red">*</span>Vehicle Tools</label>
                            <div class="col-sm-2">
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input checked="checked" value="1" type="radio" class="form-check-input" name="CF04" >Yes
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input value="0" type="radio" class="form-check-input" name="CF04" >No
                  </label>
                </div>
              </div>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" name="CC03" id="CC03" maxlength="20">
              </div>
            </div>
            <div class="form-group row">
              <label for="CF05" class="col-sm-3 col-form-label"><span style="color:red">*</span>Fire Extinguisher</label>
                            <div class="col-sm-2">
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input checked="checked" value="1" type="radio" class="form-check-input" name="CF05" >Yes
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input value="0" type="radio" class="form-check-input" name="CF05" >No
                  </label>
                </div>
              </div>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" name="CC04" id="CC04" maxlength="20">
              </div>
            </div>
            <div class="form-group row">
              <label for="CF06" class="col-sm-3 col-form-label"><span style="color:red">*</span>Front Lights (Deem) L/R</label>
                            <div class="col-sm-2">
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input checked="checked" value="1" type="radio" class="form-check-input" name="CF06" >Yes
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input value="0" type="radio" class="form-check-input" name="CF06" >No
                  </label>
                </div>
              </div>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" name="CC05" id="CC05" maxlength="20">
              </div>
            </div>
            <div class="form-group row">
              <label for="CF07" class="col-sm-3 col-form-label"><span style="color:red">*</span>Front Lights (High) L/R</label>
                            <div class="col-sm-2">
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input checked="checked" value="1" type="radio" class="form-check-input" name="CF07" >Yes
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input value="0" type="radio" class="form-check-input" name="CF07">No
                  </label>
                </div>
              </div>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" name="CC06" id="CC06" maxlength="20">
              </div>
            </div>
            <div class="form-group row">
              <label for="CF08" class="col-sm-3 col-form-label"><span style="color:red">*</span>Indicator Lights (FL/FR/RL/RR)</label>
                            <div class="col-sm-2">
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input checked="checked" value="1" type="radio" class="form-check-input" name="CF08" >Yes
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input value="0" type="radio" class="form-check-input" name="CF08" >No
                  </label>
                </div>
              </div>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" name="CC07" id="CC07" maxlength="20">
              </div>
            </div>
                        <div class="form-group row">
              <label for="CF09" class="col-sm-3 col-form-label"><span style="color:red">*</span>Parking Lights L/R</label>
                            <div class="col-sm-2">
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input checked="checked" value="1" type="radio" class="form-check-input" name="CF09" >Yes
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input value="0" type="radio" class="form-check-input" name="CF09" >No
                  </label>
                </div>
              </div>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" name="CC08" id="CC08" maxlength="20">
              </div>
            </div>
                        <div class="form-group row">
              <label for="CF10" class="col-sm-3 col-form-label"><span style="color:red">*</span>Brake Lights L/R</label>
                            <div class="col-sm-2">
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input checked="checked" value="1" type="radio" class="form-check-input" name="CF10" >Yes
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input value="0" type="radio" class="form-check-input" name="CF10" >No
                  </label>
                </div>
              </div>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" name="CC09" id="CC09" maxlength="20">
              </div>
            </div>
                        <div class="form-group row">
              <label for="CF11" class="col-sm-3 col-form-label"><span style="color:red">*</span>Reverse Lights L/R</label>
                            <div class="col-sm-2">
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input checked="checked" value="1" type="radio" class="form-check-input" name="CF11" >Yes
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input value="0" type="radio" class="form-check-input" name="CF11" >No
                  </label>
                </div>
              </div>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" name="CC10" id="CC10" maxlength="20">
              </div>
            </div>
                        <div class="form-group row">
              <label for="CF12" class="col-sm-3 col-form-label"><span style="color:red">*</span>Wiper Function</label>
                            <div class="col-sm-2">
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input checked="checked" value="1" type="radio" class="form-check-input" name="CF12" >Yes
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input value="0" type="radio" class="form-check-input" name="CF12" >No
                  </label>
                </div>
              </div>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" name="CC11" id="CC11" maxlength="20">
              </div>
            </div>
                        <div class="form-group row">
              <label for="CF13" class="col-sm-3 col-form-label"><span style="color:red">*</span>Horn</label>
                            <div class="col-sm-2">
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input checked="checked" value="1" type="radio" class="form-check-input" name="CF13" >Yes
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input value="0" type="radio" class="form-check-input" name="CF13" >No
                  </label>
                </div>
              </div>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" name="CC12" id="CC12" maxlength="20">
              </div>
            </div>
                        <div class="form-group row">
              <label for="CF14" class="col-sm-3 col-form-label"><span style="color:red">*</span>Air-Conditioner</label>
                            <div class="col-sm-2">
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input checked="checked" value="1" type="radio" class="form-check-input" name="CF14" >Yes
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input value="0" type="radio" class="form-check-input" name="CF14" >No
                  </label>
                </div>
              </div>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" name="CC13" id="CC13" maxlength="20">
              </div>
            </div>
                        <div class="form-group row">
              <label for="CF15" class="col-sm-3 col-form-label"><span style="color:red">*</span>Radio</label>
                            <div class="col-sm-2">
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input checked="checked" value="1" type="radio" class="form-check-input" name="CF15" >Yes
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input value="0" type="radio" class="form-check-input" name="CF15" >No
                  </label>
                </div>
              </div>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" name="CC14" id="CC14" maxlength="20">
              </div>
            </div>
                        <div class="form-group row">
              <label for="CF16" class="col-sm-3 col-form-label"><span style="color:red">*</span>Wheel Caps (FL/FR/RL/RR</label>
                            <div class="col-sm-2">
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input checked="checked" value="1" type="radio" class="form-check-input" name="CF16" >Yes
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input value="0" type="radio" class="form-check-input" name="CF16" >No
                  </label>
                </div>
              </div>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" name="CC15" id="CC15" maxlength="20">
              </div>
            </div>
                        <div class="form-group row">
              <label for="CF17" class="col-sm-3 col-form-label"><span style="color:red">*</span>Road Test</label>
                            <div class="col-sm-2">
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input checked="checked" value="1" type="radio" class="form-check-input" name="CF17" >Yes
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input value="0" type="radio" class="form-check-input" name="CF17" >No
                  </label>
                </div>
              </div>
              <div class="col-sm-4">
                <input type="text" class="form-control form-control-sm" name="CC16" id="CC16" maxlength="20">
              </div>
            </div>
                        <div class="form-group row">
              <label for="CF18" class="col-sm-3 col-form-label"><span style="color:red">*</span>Comments</label>
              <div class="col-sm-6">
                <input type="text" required="required" class="form-control form-control-sm" name="CF18" id="CF18" maxlength="20">
              </div>
            </div>

                        <div class="form-group row">
              <label for="CFP2" class="col-sm-3 col-form-label"><span style="color:red">*</span>Front View</label>
              <div class="col-sm-6">
                <img id="CFP2p"  />
                <input required="required" onchange="readURL(this,'CFP2p');" accept="image/png, image/jpeg" name="CFP2" type="file" id="CFP2">
              </div>
            </div>
            <div class="form-group row">
              <label for="CFP3" class="col-sm-3 col-form-label"><span style="color:red">*</span>Right View</label>
              <div class="col-sm-6">
                <img id="CFP3p"  />
                <input required="required" onchange="readURL(this,'CFP3p');" accept="image/png, image/jpeg" name="CFP3" type="file" id="CFP3">
              </div>
            </div>
            <div class="form-group row">
              <label for="CFP4" class="col-sm-3 col-form-label"><span style="color:red">*</span>Rear View</label>
              <div class="col-sm-6">
                <img id="CFP4p"  />
                <input required="required" onchange="readURL(this,'CFP4p');" accept="image/png, image/jpeg" name="CFP4" type="file" id="CFP4">
              </div>
            </div>
            <div class="form-group row">
              <label for="CFP5" class="col-sm-3 col-form-label"><span style="color:red">*</span>Left View</label>
              <div class="col-sm-6">
                <img id="CFP5p"  />
                <input required="required" onchange="readURL(this,'CFP5p');" accept="image/png, image/jpeg" name="CFP5" type="file" id="CFP5">
              </div>
            </div>
          </div>
           
    </div>
			
				<div class="form-group row">
					<div class="col-md-12 text-center">
						<input onclick="return confirm('Are you sure to unassign the vehicle?')" required="required" class="btn btn-danger"
						type="submit"
						name="submit" value="Unassign"/>
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

    function validate_all(e){
  
    var selection = document.getElementById('CFP2');
    for (var i=0; i<selection.files.length; i++) {
        if(selection.files[i].size > 5000000){
          alert('Vehicle Front image file size can be a maximum of 5MB');
            return false;
        }
    } 
    selection = document.getElementById('CFP3');
    for (var i=0; i<selection.files.length; i++) {
        if(selection.files[i].size > 5000000){
          alert('Vehicle Right image file size can be a maximum of 5MB');
            return false;
        }
    } 

    selection = document.getElementById('CFP4');
    for (var i=0; i<selection.files.length; i++) {
        if(selection.files[i].size > 5000000){
          alert('Vehicle Rear image file size can be a maximum of 5MB');
            return false;
        }
    } 

    selection = document.getElementById('CFP5');
    for (var i=0; i<selection.files.length; i++) {
        if(selection.files[i].size > 5000000){
          alert('Vehicle Left image file size can be a maximum of 5MB');
            return false;
        }
    } 
  }
</script>
@endpush