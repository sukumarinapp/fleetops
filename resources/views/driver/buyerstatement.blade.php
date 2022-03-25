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
      <h5 class="title" style="text-align:center;">Buyer Statement</h5>
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
<div><strong>Buyer : </strong> <span>{{ $DNM }}</span></div>
<div><strong>Start : </strong> <span>08-04-21 </span></div>
<div><strong>End : </strong> <span>07-04-23 </span></div>
<div><strong>Installments : </strong> <span>29/104  </span></div>
</div>

</div>

<div class="col-md-12">
  <div class="row">
<div class="table-responsive">
  <table id="buyerst" class="table table-striped table-bordered">
<thead>
          <tr>
            <th>Date</th>
            <th>Payment Reference</th>
            <th>Transaction Details</th>
            <th>Debit</th>
            <th>Credit</th>
            <th>Balance</th>
          </tr>
          </thead>
          <tbody>
            <tr>
              <td></td>
              <td></td>
              <td>Vehicle</td>
               <td>{{ $PPR }}</td>
               <td></td>
               <td>{{ $PPR }}</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td>Down payment</td>
               <td></td>
               <td>{{ $PDP }}</td>
               <td>{{ number_format($PPR - $PDP,2) }}</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td>Security Deposit</td>
               <td>{{ $SDP }}</td>
               <td></td>
               <td>{{ number_format($PPR - $PDP + $SDP,2) }}</td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td>Security Paid</td>
               <td></td>
               <td>{{ $SDP }}</td>
               <td>{{ number_format($PPR - $PDP,2) }}</td>
            </tr>
            @php
              $balance = $PPR - $PDP;
            @endphp
            @foreach($result as $res)
            @php
              $balance = $balance - ($res->RMT);
            @endphp
            <tr>
              <td>{{ date('d-M-Y', strtotime($res->SDT)) }}</td>
              <td>{{ $res->RNO }}</td>
              <td>{{ $res->VPF }}</td>
               <td></td>
               <td>{{ $res->RMT }}</td>
               <td>{{ number_format($balance ,2) }}</td>
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