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
								<li class="breadcrumb-item"><a href="{{ route('workflow') }}">Workflow</a></li>
								<li class="breadcrumb-item">Resolve Licence</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
			<div class="card card-info">
				<div class="card-header">
					<h3 class="card-title">Resolve Licence Expiry</h3>
				</div>
				<div class="table-responsive">
					<div class="card-body">
						<form onsubmit="return validate_all(event)" action="{{ route('save_new_licence') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
							@csrf
							<input type="hidden" name="driver_id" value="{{ $driver_id }}" />
							<input type="hidden" name="upload_id" value="{{ $upload_id }}" />
							<input type="hidden" name="VNO" value="{{ $VNO }}" />
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
										<label for="DLD" class="col-sm-4 col-form-label"><span style="color:red">*</span>Licence Front</label>
										<div class="col-sm-8">
											<input onchange="readURL(this,'lic');" required="required" accept="application/pdf,image/png, image/jpeg" name="DLD" type="file" id="DLD">
											<img id="lic"  />
										</div>
									</div>
									<div class="form-group row">
										<label for="DLD2" class="col-sm-4 col-form-label"><span style="color:red">*</span>Licence Back</label>
										<div class="col-sm-8">
											<input onchange="readURL(this,'lic2');" required="required" accept="application/pdf,image/png, image/jpeg" name="DLD2" type="file" id="DLD2">
											 <img id="lic2"  />
										</div>
									</div>
									<div class="form-group row">
										<label for="LEX" class="col-sm-4 col-form-label"><span style="color:red">*</span>Licence Expiry Date</label>
										<div class="col-sm-4">
											<input min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required="required" onkeydown="return false" type="date" class="form-control" name="LEX" id="LEX" >
										</div>
									</div>
									@if($file_name != "")
									<div class="form-group row">
										<table class="table table-bordered">
											<thead>
												<tr>
													<th colspan="2" style="text-align:center;">Licence uploaded by driver</th>
												</tr> 
												<tr>
													<th>Expiry Date</th>
													<th>Licence</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>{{ date("d/m/Y",strtotime($doc_expiry)) }}</td>
													<td>
														<a target="_blank" href="../uploads/driver/{{ $file_name }}" >Licence Front</a>
													<br>
													  <a target="_blank" href="../uploads/driver/{{ $file_name2 }}" >Licence Back</a>
													</td>
													<td><a onclick="approve_licence( {{ $upload_id }} )" class="btn btn-success btn-sm">Approve</a>
														<a onclick="reject_doc('{{ $upload_id }}')" class="btn btn-danger btn-sm" >Reject</a>
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
@push('page_scripts')
<script>
var approve_licence_url = "{{ url('approve_licence') }}";
function approve_licence(upload_id){
  var url =  approve_licence_url+"/"+upload_id;
  $.ajax({
      type: "get",
      url: url,
      success: function(response) {
        window.location.href = "{{ url('workflow') }}";
      },
      error: function (jqXHR, exception) {
        console.log(exception);
      }
  });
}
var reject_url = "{{ url('reject_doc') }}";
function reject_doc(upload_id){
  var url =  reject_url +"/" + upload_id;
  $.ajax({
      type: "get",
      url: url,
      success: function(response) {
        window.location.href = "{{ url('workflow') }}";
      },
      error: function (jqXHR, exception) {
        console.log(exception);
      }
  });
}

function validate_all(e){
	
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