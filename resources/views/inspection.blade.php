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
						<li class="breadcrumb-item"><a href="{{ route('workflow') }}">Workflow</a></li>
						<li class="breadcrumb-item">Vehicle Inspection</li>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<div class="card card-info">
		<div class="card-header">
			<h3 class="card-title">Vehicle Inspection Form</h3>
		</div>

		<div class="card-body">
			<div class="row mb-4">
				<div class="col-sm-6">
					<div>
					</div>
					<div><strong>Vehicle Reg. No :</strong><span>{{ $VNO }}</span></div>
					<div><strong>Vehicle Chassis No :</strong><span></span></div>
				</div>

			</div>
			<form action="{{ route('saveinspection') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
				@csrf
				<input type="hidden" name="VNO" value="{{ $VNO }}" />
				<input type="hidden" name="upload_id" value="{{ $upload_id }}" />
				<div class="row">
					<div class="col-md-6">

						<div class="form-group row">
							<label for="DNO" class="col-sm-6 col-form-label"><span style="color:red">*</span>Look under the car for leaks</label>
							<div class="col-sm-3">
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
							<div class="col-sm-3">
								<input type="text" class="form-control form-control-sm" name="CI01" id="CI01" maxlength="20">
							</div>
						</div>

						<div class="form-group row">
							<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check radiator coolant level</label>
							<div class="col-sm-3">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input checked="checked" value="1" type="radio" class="form-check-input" name="VI02">Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI02">No
									</label>
								</div>
							</div>
							<div class="col-sm-3">
								<input  type="text" class="form-control form-control-sm" name="CI02" id="CI02" maxlength="20">
							</div>
						</div>

						<div class="form-group row">
							<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check engine oil level</label>
							<div class="col-sm-3">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="1" checked="checked" type="radio" class="form-check-input" name="VI03">Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI03">No
									</label>
								</div>
							</div>
							<div class="col-sm-3">
								<input  type="text" class="form-control form-control-sm" name="CI03" id="CI03" maxlength="20">
							</div>
						</div>

						<div class="form-group row">
							<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check brake fluid</label>
							<div class="col-sm-3">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="1" checked="checked" type="radio" class="form-check-input" name="VI04">Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI04">No
									</label>
								</div>
							</div>
							<div class="col-sm-3">
								<input  type="text" class="form-control form-control-sm" name="CI04" id="CI04" maxlength="20">
							</div>
						</div>

						<div class="form-group row">
							<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check windshield washer fluid</label>
							<div class="col-sm-3">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="1" checked="checked" type="radio" class="form-check-input" name="VI05">Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI05">No
									</label>
								</div>
							</div>
							<div class="col-sm-3">
								<input  type="text" class="form-control form-control-sm" name="CI05" id="CI05" maxlength="20">
							</div>
						</div>

						<div class="form-group row">
							<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check battery condition</label>
							<div class="col-sm-3">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="1" checked="checked" type="radio" class="form-check-input" name="VI06">Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI06">No
									</label>
								</div>
							</div>
							<div class="col-sm-3">
								<input  type="text" class="form-control form-control-sm" name="CI06" id="CI06" maxlength="20">
							</div>
						</div>

						<div class="form-group row">
							<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check general cleanliness of engine</label>
							<div class="col-sm-3">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="1" checked="checked" type="radio" class="form-check-input" name="VI07">Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI07">No
									</label>
								</div>
							</div>
							<div class="col-sm-3">
								<input  type="text" class="form-control form-control-sm" name="CI07" id="CI07" maxlength="20">
							</div>
						</div>

						<div class="form-group row">
							<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check tire condition, caps, nuts and tools</label>
							<div class="col-sm-3">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="1" checked="checked" type="radio" class="form-check-input" name="VI08">Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI08">No
									</label>
								</div>
							</div>
							<div class="col-sm-3">
								<input  type="text" class="form-control form-control-sm" name="CI08" id="CI08" maxlength="20">
							</div>
						</div>

						<div class="form-group row">
							<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check brakes (Foot/Hand Brakes)</label>
							<div class="col-sm-3">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="1" checked="checked" type="radio" class="form-check-input" name="VI09">Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI09">No
									</label>
								</div>
							</div>
							<div class="col-sm-3">
								<input type="text" class="form-control form-control-sm" name="CI09" id="CI09" maxlength="20">
							</div>
						</div>

						<div class="form-group row">
							<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check inside mirror and side mirrors</label>
							<div class="col-sm-3">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="1" checked="checked" type="radio" class="form-check-input" name="VI10">Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI10">No
									</label>
								</div>
							</div>
							<div class="col-sm-3">
								<input type="text" class="form-control form-control-sm" name="CI10" id="CI10" maxlength="20">
							</div>
						</div>

						<div class="form-group row">
							<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check all windows left/right windows</label>
							<div class="col-sm-3">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="1" checked="checked" type="radio" class="form-check-input" name="VI11">Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI11">No
									</label>
								</div>
							</div>
							<div class="col-sm-3">
								<input  type="text" class="form-control form-control-sm" name="CI11" id="CI11" maxlength="20">
							</div>
						</div>

						<div class="form-group row">
							<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check doors, handles, boot and hood</label>
							<div class="col-sm-3">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="1" checked="checked" type="radio" class="form-check-input" name="VI12">Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI12">No
									</label>
								</div>
							</div>
							<div class="col-sm-3">
								<input  type="text" class="form-control form-control-sm" name="CI12" id="CI12" maxlength="20">
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group row">
							<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check headlights, brakes lights</label>
							<div class="col-sm-3">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="1" checked="checked" type="radio" class="form-check-input" name="VI13">Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI13">No
									</label>
								</div>
							</div>
							<div class="col-sm-3">
								<input  type="text" class="form-control form-control-sm" name="CI13" id="CI13" maxlength="20">
							</div>
						</div>

						<div class="form-group row">
							<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check ignition key and system</label>
							<div class="col-sm-3">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="1" checked="checked" type="radio" class="form-check-input" name="VI14">Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI14">No
									</label>
								</div>
							</div>
							<div class="col-sm-3">
								<input  type="text" class="form-control form-control-sm" name="CI14" id="CI14" maxlength="20">
							</div>
						</div>

						<div class="form-group row">
							<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check steering wheel</label>
							<div class="col-sm-3">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="1" checked="checked" type="radio" class="form-check-input" name="VI15">Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI15">No
									</label>
								</div>
							</div>
							<div class="col-sm-3">
								<input  type="text" class="form-control form-control-sm" name="CI15" id="CI15" maxlength="20">
							</div>
						</div>

						<div class="form-group row">
							<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check dashboard indicator lights</label>
							<div class="col-sm-3">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="1" checked="checked" type="radio" class="form-check-input" name="VI16">Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI16">No
									</label>
								</div>
							</div>
							<div class="col-sm-3">
								<input  type="text" class="form-control form-control-sm" name="CI16" id="CI16" maxlength="20">
							</div>
						</div>

						<div class="form-group row">
							<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check inside lights</label>
							<div class="col-sm-3">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="1" checked="checked" type="radio" class="form-check-input" name="VI17">Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI17">No
									</label>
								</div>
							</div>
							<div class="col-sm-3">
								<input  type="text" class="form-control form-control-sm" name="CI17" id="CI17" maxlength="20">
							</div>
						</div>

						<div class="form-group row">
							<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check radio and CD player/antenna</label>
							<div class="col-sm-3">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="1" checked="checked" type="radio" class="form-check-input" name="VI18">Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI18">No
									</label>
								</div>
							</div>
							<div class="col-sm-3">
								<input  type="text" class="form-control form-control-sm" name="CI18" id="CI18" maxlength="20">
							</div>
						</div>

						<div class="form-group row">
							<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check seat belts and seat covers</label>
							<div class="col-sm-3">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="1" checked="checked" type="radio" class="form-check-input" name="VI19">Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI19">No
									</label>
								</div>
							</div>
							<div class="col-sm-3">
								<input  type="text" class="form-control form-control-sm" name="CI19" id="CI19" maxlength="20">
							</div>
						</div>

						<div class="form-group row">
							<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check cleanliness of the vehicle's interior</label>
							<div class="col-sm-3">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="1" checked="checked" type="radio" class="form-check-input" name="VI20">Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI20">No
									</label>
								</div>
							</div>
							<div class="col-sm-3">
								<input  type="text" class="form-control form-control-sm" name="CI20" id="CI20" maxlength="20">
							</div>
						</div>

						<div class="form-group row">
							<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check first aid kit and fire extinguisher</label>
							<div class="col-sm-3">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="1" checked="checked" type="radio" class="form-check-input" name="VI21">Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI21">No
									</label>
								</div>
							</div>
							<div class="col-sm-3">
								<input  type="text" class="form-control form-control-sm" name="CI21" id="CI21" maxlength="20">
							</div>
						</div>

						<div class="form-group row">
							<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check reflective triangles</label>
							<div class="col-sm-3">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="1" checked="checked" type="radio" class="form-check-input" name="VI22">Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI22">No
									</label>
								</div>
							</div>
							<div class="col-sm-3">
								<input  type="text" class="form-control form-control-sm" name="CI22" id="CI22" maxlength="30">
							</div>
						</div>

						<div class="form-group row">
							<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check validity of insurance (Sticker)</label>
							<div class="col-sm-3">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="1" checked="checked" type="radio" class="form-check-input" name="VI23">Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI23">No
									</label>
								</div>
							</div>
							<div class="col-sm-3">
								<input  type="text" class="form-control form-control-sm" name="CI23" id="CI23" maxlength="30">
							</div>
						</div>

						<div class="form-group row">
							<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check validity of Roadworthy (Sticker)</label>
							<div class="col-sm-3">
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="1" checked="checked" type="radio" class="form-check-input" name="VI24">Yes
									</label>
								</div>
								<div class="form-check-inline">
									<label class="form-check-label">
										<input value="0" type="radio" class="form-check-input" name="VI24">No
									</label>
								</div>
							</div>
							<div class="col-sm-3">
								<input  type="text" class="form-control form-control-sm" name="CI24" id="CI24" maxlength="30">
							</div>
						</div>

						<div class="form-group row">
							<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Physical Dents & Damages (Pictures)</label>
							<div class="col-sm-6">
								<input type="file" name="VI25[]" multiple accept="image/png,image/jpeg">
							</div>
						</div>


					</div>
				</div>

			</div>
			<div class="form-group row">
				<div class="col-md-12 text-center">
					<input required="required" class="btn btn-info"
					type="submit" id="save" name="submit" value="Save"/>
					<a href="{{ route('workflow') }}" class="btn btn-info">Back</a>
				</div>
			</div>	

		</div>
	</div>
</form>
</section>

@endsection
