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
								<li class="breadcrumb-item">Add Vehicle</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Resolve Insurance Expiry</h3>
				</div>
				<div class="table-responsive">
					<div class="card-body">
						<form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
							@csrf
							<div class="row">
								<div class="col-md-6">
									<div class="form-group row">
										<label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Driver Name</label>
										<div class="col-sm-8">
											{{ $DNM }}
										</div>
									</div>
									<div class="form-group row">
										<label for="" class="col-sm-4 col-form-label"><span style="color:red"></span>Vehicle Reg No</label>
										<div class="col-sm-8">
											{{ $VNO }}
										</div>
									</div>
									<div class="form-group row">
										<label for="VID" class="col-sm-4 col-form-label"><span style="color:red">*</span>Insurance</label>
										<div class="col-sm-8">
											<input required="required" accept="application/pdf,image/png, image/jpeg" name="VID" type="file" id="VID">
										</div>
									</div>
									<div class="form-group row">
										<label for="IEX" class="col-sm-4 col-form-label"><span style="color:red">*</span>Insurance Expiry Date</label>
										<div class="col-sm-8">
											<input min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required="required" onkeydown="return false" type="date" class="form-control" name="IEX" id="IEX" >
										</div>
									</div>
									@if($file_name != "")
									<div class="form-group row">
										<table class="table table-bordered">
											<thead>
												<tr>
													<th colspan="2" style="text-align:center;">Insurance uploaded by driver</th>
												</tr> 
												<tr>
													<th>Expiry Date</th>
													<th>Insurance</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>{{ date("d/m/Y",strtotime($doc_expiry)) }}</td>
													<td><a target="_blank" href="../uploads/driver/{{ $file_name }}" >View</a></td>
													<td><a href="#" class="btn btn-success btn-sm">Approve</a>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									@endif
								</div>
								<!-- /.col -->
							</div>
							<div class="col-md-12 text-center">
								<input id="save" required="required" class="btn btn-info"	type="submit" name="submit" value="Save"/>
								<a href="{{ route('workflow') }}" class="btn btn-info">Back</a>
							</div>
						</div>	
					</div>
				</div>

			</form> 
		</section>

		@endsection
