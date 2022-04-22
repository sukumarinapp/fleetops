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
              <li class="breadcrumb-item">Driver Manager</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
			<div class="card card-info">
			<div class="card-header">
			<h3 class="card-title">Driver Manager</h3>
			<a href="{{ route('fdriver.create') }}" class="btn btn-secondary float-right"><i class="nav-icon fas fa-plus"></i>&nbsp; Add Driver</a>
		    </div>
			<div style="overflow-x: auto;" class="card-body">
        @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissable" style="margin: 15px;">
                <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong> {{ session('error') }} </strong>
            </div>
        @endif
        @if(session()->has('message'))
          <div class="alert alert-success alert-dismissable" style="margin: 15px;">
              <a href="#" style="color:white !important" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong> {{ session('message') }} </strong>
          </div>
        @endif
			<table id="example1" class="table table-bordered">
          <thead>
          <tr>
            <th>Driver Name</th>
            <th>License #</th>
            <th>Contact #</th>
            <th>Business Model</th>
            <th>Status</th>
            <th style="width :100px">Business SMS</th>
            <th>View</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
            @foreach($drivers as $driver)
            <tr
            @if($driver->VNO == "")
              style="color: #FFC300;"
            @endif
            >
              <td>
               @php
                if($driver->VNO != ""){
                   echo "<span><img src='assign.jpg'></span>";
                 }
                 @endphp

                {{ $driver->DNM }} {{ $driver->DSN }}
              @if($driver->VNO !="")
                <br><small class="text-success"><a href="{{ route('vehicle.edit',$driver->vid) }}">{{ $driver->VNO }}</a></small>
              @endif
              </td>
              <td>{{ $driver->DNO }}</td>
              <td>{{ $driver->DCN }}</td>
              <td>{{ $driver->VBM }}</td>
              <td>
                @if($driver->VNO !="")
                  Linked
                @else
                  Not Linked
                @endif
              </td>
               <td>
                @if($driver->vid== "")
                  &nbsp;
                @else                  
                  <a href="{{ route('resendsms',$driver->vid) }}" class="btn btn-primary btn-xs">Resend</a>
                @endif
               </td>
               <td>
                @if($driver->photo != "")
                <a href="#" data-toggle="modal" data-target="#photomodal_{{ $driver->id }}" ><img src="{{ URL::to('/') }}/photo.png"></a>
                @else
                <a><img src="{{ URL::to('/') }}/photo.png"></a>
                @endif
                <a href="#" data-toggle="modal" data-target="#licencemodal_{{ $driver->id }}" ><img src="{{ URL::to('/') }}/licence.jpg"></a>
              @if($driver->handover_id == 0)
              @else
              <a target="_blank" href="../../uploads/handover/{{ $driver->handover_id }}.pdf"><img src="{{ URL::to('/') }}/handover.jpg"></a>
              @endif
               </td>
              <td>
                
                @if($driver->VNO == "")
                <form action="{{ route('fdriver.destroy', $driver->id)}}" method="post">
                @endif
                    <a href="{{ route('fdriver.edit',$driver->id) }}" class="btn btn-primary btn-xs">Edit</a>
                    @csrf
                    @method('DELETE')
                  @if($driver->VNO == "")
                  <button onclick="return confirm('Do you want to perform delete operation?')" class="btn btn-danger btn-xs" type="submit">Delete</button>
                  @else
                  <button class="btn btn-danger btn-xs disabled" >Delete</button>
                  @endif
                @if($driver->VNO == "")
                </form>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
      </table>
			</div>
      @foreach($drivers as $driver)
      @if($driver->photo != "")
      <div aria-hidden="true" id="photomodal_{{ $driver->id }}" class="modal fade">
        <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Photo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>
          <img src="uploads/photo/{{ $driver->photo }}" />
        </div>
      </div>
      </div>
      @endif
      <div aria-hidden="true" id="licencemodal_{{ $driver->id }}" class="modal fade">
        <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Licence</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            </div>
          <img src="uploads/DLD/{{ $driver->DLD }}" />
          <img src="uploads/DLD/{{ $driver->DLD2 }}" />
        </div>
      </div>
      </div>
      @endforeach
		</div>
		</div>
	</div>
</div>
@endsection