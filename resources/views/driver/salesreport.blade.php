@extends('layouts.driver')
@section('content')
<div class="container" >
 <div class="row justify-content-center">
  <div class="col-md-12 text-center">
    <a href="#" class="navbar-brand">
                <img src="{{ URL::to('/') }}/images/fleetopslogo.png" alt="AdminLTE Logo">
            </a>
    <h3 style="color: lightgray">My Account</h3>
  </div>
</div>
<div class="card card-info">
  <div class="card-header">
      <h5 class="title" style="text-align:center;">Sales Report</h5>
  </div>
<div class="card-body">
<div class="row mb-4">
<div class="col-sm-6">
<div>
<strong>Vehicle {{ $VBM }}</strong>
</div>
<div>{{ $VMK }} <span>( {{ $VNO}} )</span></div>
<div>Vendor</div>
<div>FleetOps & Vantage Ltd </div>
</div>

<div class="col-sm-6">
  <h6 class="mb-3"></h6>
<div><strong>Date : </strong> <span>{{ date("l M d Y")}}</span></div>
<div><strong>Customer : </strong> <span>{{ $DNM }}</span></div>
<div><strong>Address : </strong> <span>Accra</span></div>
</div>

</div>

<div class="col-md-12">
  <div class="row">
<div class="table-responsive">
  <table class="table table-striped">
<thead>
          <tr>
            <th>Date</th>
            <th>RH Platform</th>
            <th>Sales</th>
            <th>Cash Collected</th>
            <th>Trips</th>
            <th>Status</th>
            <th>Payment</th>
            
          </tr>
          </thead>
          <tbody>
             @foreach($result as $res)
            <tr>
              <td>{{ date('d-M-Y', strtotime($res->SDT)) }}</td>
              <td>{{ $res->RHN }}</td>
              <td>{{ $res->SPF }}</td>
              <td>{{ $res->RMT }}</td>
              <td>{{ $res->TPF }}</td>
              <td>Pass</td>
              <td>
                @if($res->RST == 1)
                   Cleared;
                @else
                   Pending;
                @endif</td>
            </tr>
            
            @endforeach
          </tbody>  </table>
</div>

</div>
<nav class="navbar fixed-bottom navbar-expand-lg justify-content-center">      
  <a href="{{ url('myaccount') }}" class="btn btn-info">Back</a>&nbsp;
  <a href="{{ route('driver') }}" class="btn btn-info">Logout</a>
</nav>
</div>
</div>
</div>
</div>

@endsection