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
<div><strong>Vehicle Reg. No :</strong><span></span></div>
<div><strong>Vehicle Chassis No :</strong><span></span></div>
</div>

</div>
					<form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
						@csrf
						<div class="row">
							<div class="col-md-6">

								<div class="form-group row">
									<label for="DNO" class="col-sm-6 col-form-label"><span style="color:red">*</span>Look under the car for leaks</label>
									<div class="col-sm-3">
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">Yes
											</label>
										</div>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">No
											</label>
										</div>
									</div>
									<div class="col-sm-3">
										<input type="text" class="form-control form-control-sm" name="" id="" maxlength="30">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check radiator coolant level</label>
									<div class="col-sm-3">
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">Yes
											</label>
										</div>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">No
											</label>
										</div>
									</div>
									<div class="col-sm-3">
										<input  type="text" class="form-control form-control-sm" name="" id="" maxlength="30">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check engine oil level</label>
									<div class="col-sm-3">
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">Yes
											</label>
										</div>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">No
											</label>
										</div>
									</div>
									<div class="col-sm-3">
										<input  type="text" class="form-control form-control-sm" name="" id="" maxlength="30">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check brake fluid</label>
									<div class="col-sm-3">
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">Yes
											</label>
										</div>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">No
											</label>
										</div>
									</div>
									<div class="col-sm-3">
										<input  type="text" class="form-control form-control-sm" name="" id="" maxlength="30">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check windshield washer fluid</label>
									<div class="col-sm-3">
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">Yes
											</label>
										</div>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">No
											</label>
										</div>
									</div>
									<div class="col-sm-3">
										<input  type="text" class="form-control form-control-sm" name="" id="" maxlength="30">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check battery condition</label>
									<div class="col-sm-3">
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">Yes
											</label>
										</div>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">No
											</label>
										</div>
									</div>
									<div class="col-sm-3">
										<input  type="text" class="form-control form-control-sm" name="" id="" maxlength="30">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check general cleanliness of engine</label>
									<div class="col-sm-3">
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">Yes
											</label>
										</div>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">No
											</label>
										</div>
									</div>
									<div class="col-sm-3">
										<input  type="text" class="form-control form-control-sm" name="" id="" maxlength="30">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check tire condition, caps, nuts and tools</label>
									<div class="col-sm-3">
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">Yes
											</label>
										</div>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">No
											</label>
										</div>
									</div>
									<div class="col-sm-3">
										<input  type="text" class="form-control form-control-sm" name="" id="" maxlength="30">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check brakes (Foot/Hand Brakes)</label>
									<div class="col-sm-3">
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">Yes
											</label>
										</div>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">No
											</label>
										</div>
									</div>
									<div class="col-sm-3">
										<input  type="text" class="form-control form-control-sm" name="" id="" maxlength="30">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check inside mirror and side mirrors</label>
									<div class="col-sm-3">
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">Yes
											</label>
										</div>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">No
											</label>
										</div>
									</div>
									<div class="col-sm-3">
										<input  type="text" class="form-control form-control-sm" name="" id="" maxlength="30">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check all windows left/right windows</label>
									<div class="col-sm-3">
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">Yes
											</label>
										</div>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">No
											</label>
										</div>
									</div>
									<div class="col-sm-3">
										<input  type="text" class="form-control form-control-sm" name="" id="" maxlength="30">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check doors, handles, boot and hood</label>
									<div class="col-sm-3">
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">Yes
											</label>
										</div>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">No
											</label>
										</div>
									</div>
									<div class="col-sm-3">
										<input  type="text" class="form-control form-control-sm" name="" id="" maxlength="30">
									</div>
								</div>
							</div>
           <div class="col-md-6">
								<div class="form-group row">
									<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check headlights, brakes lights</label>
									<div class="col-sm-3">
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">Yes
											</label>
										</div>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">No
											</label>
										</div>
									</div>
									<div class="col-sm-3">
										<input  type="text" class="form-control form-control-sm" name="" id="" maxlength="30">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check ignition key and system</label>
									<div class="col-sm-3">
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">Yes
											</label>
										</div>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">No
											</label>
										</div>
									</div>
									<div class="col-sm-3">
										<input  type="text" class="form-control form-control-sm" name="" id="" maxlength="30">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check steering wheel</label>
									<div class="col-sm-3">
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">Yes
											</label>
										</div>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">No
											</label>
										</div>
									</div>
									<div class="col-sm-3">
										<input  type="text" class="form-control form-control-sm" name="" id="" maxlength="30">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check dashboard indicator lights</label>
									<div class="col-sm-3">
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">Yes
											</label>
										</div>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">No
											</label>
										</div>
									</div>
									<div class="col-sm-3">
										<input  type="text" class="form-control form-control-sm" name="" id="" maxlength="30">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check inside lights</label>
									<div class="col-sm-3">
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">Yes
											</label>
										</div>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">No
											</label>
										</div>
									</div>
									<div class="col-sm-3">
										<input  type="text" class="form-control form-control-sm" name="" id="" maxlength="30">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check radio and CD player/antenna</label>
									<div class="col-sm-3">
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">Yes
											</label>
										</div>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">No
											</label>
										</div>
									</div>
									<div class="col-sm-3">
										<input  type="text" class="form-control form-control-sm" name="" id="" maxlength="30">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check seat belts and seat covers</label>
									<div class="col-sm-3">
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">Yes
											</label>
										</div>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">No
											</label>
										</div>
									</div>
									<div class="col-sm-3">
										<input  type="text" class="form-control form-control-sm" name="" id="" maxlength="30">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check cleanliness of the vehicle's interior</label>
									<div class="col-sm-3">
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">Yes
											</label>
										</div>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">No
											</label>
										</div>
									</div>
									<div class="col-sm-3">
										<input  type="text" class="form-control form-control-sm" name="" id="" maxlength="30">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check first aid kit and fire extinguisher</label>
									<div class="col-sm-3">
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">Yes
											</label>
										</div>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">No
											</label>
										</div>
									</div>
									<div class="col-sm-3">
										<input  type="text" class="form-control form-control-sm" name="" id="" maxlength="30">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check reflective triangles</label>
									<div class="col-sm-3">
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">Yes
											</label>
										</div>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">No
											</label>
										</div>
									</div>
									<div class="col-sm-3">
										<input  type="text" class="form-control form-control-sm" name="" id="" maxlength="30">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check validity of insurance (Sticker)</label>
									<div class="col-sm-3">
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">Yes
											</label>
										</div>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">No
											</label>
										</div>
									</div>
									<div class="col-sm-3">
										<input  type="text" class="form-control form-control-sm" name="" id="" maxlength="30">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Check validity of Roadworthy (Sticker)</label>
									<div class="col-sm-3">
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">Yes
											</label>
										</div>
										<div class="form-check-inline">
											<label class="form-check-label">
												<input type="radio" class="form-check-input" name="optradio">No
											</label>
										</div>
									</div>
									<div class="col-sm-3">
										<input  type="text" class="form-control form-control-sm" name="" id="" maxlength="30">
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-6 col-form-label"><span style="color:red">*</span>Physical Dents & Damages (Pictures)</label>
									<div class="col-sm-6">
										<input type="file" accept="image/*" capture="capture">
								</div>
							</div>


							</div>
						</div>

					</div>
					<div class="form-group row">
						<div class="col-md-12 text-center">
							<input required="required" class="btn btn-info"
							type="submit" id="save" name="submit" value="Save"/>
							<a href="#" class="btn btn-info">Back</a>
						</div>
					</div>	

				</div>
			</div>
		</section>

		@endsection
