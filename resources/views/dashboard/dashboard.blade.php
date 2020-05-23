@extends('layouts.b4')
@section('content')
<br>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Total Contracts Available</h2>
        </div>
        <div class="card-body">
            {{ $num }}
        </div>
    </div>
</div>
<br>
@if($num > 0)
<div class="container">
    <table class="table table-striped table-bordered">
        <thead>
            <th>Pickup System</th>
            <th>Destination System</th>
            <th>Type</th>
            <th>Volume</th>
            <th>Date Expired</th>
            <th>Collateral</th>
            <th>Reward</th>
            <th>Availability</th>
        </thead>
        <tbody>
            @foreach($contracts as $contract)
            <tr>
                <td>{{ $contract['pickup'] }}</td>
                <td>{{ $contract['destination'] }}</td>
                <td>{{ $contract['type'] }}</td>
                <td>{{ number_format($contract['volume'], 2, ".", ",") }}</td>
                <td>{{ $contract['expired'] }}</td>
                <td>{{ number_format($contract['collateral'], 2, ".", ",") }}</td>
                <td>{{ number_format($contract['reward'], 2, ".", ",") }}</td>
                <td>{{ $contract['availability'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection