@extends('layouts.b4')
@section('content')
<br>
<div class="container">
    <div class="card">
        <div class="card-header">
            How to Make a Contract
        </div>
        <div class="card-body">
            <ol>
                <li>Get a quote from <a href="https://evepraisal.com">EvePraisal</a> and set the sell value as the collateral.</li>
                <li>Issue the courier contracts as 'Private' to 'United Hauling'.</li>
                <li>If utilizing a container, please note in description</li>
            </ol>
            <br>
            Join our channel "United Hauling" in game for questions and/or concerns.
        </div>
    </div>
</div>
<br>
<div class="container">
    <div class="card">
        <div class="card-header">
            Quote
        </div>
        <div class="card-body">
            {!! Form::open(['action' => 'Hauling\HaulingController@displayFormResults', 'method' => 'POST']) !!}
            <div class="form-group">
                {{ Form::label('pickup', 'Pickup System') }}
                {{ Form::text('pickup', '', ['class' => 'form-control']) }}
            </div>
            <div class="form-group">
                {{ Form::label('destination', 'Destination System') }}
                {{ Form::text('destination', '', ['class' => 'form-control']) }}
            </div>
            <div class="form-group">
                {{ Form::label('size', 'Volume') }}
                {{ Form::text('size', '', ['class' => 'form-control']) }}
            </div>
            <div class="form-group">
                {{ Form::label('collateral', 'Collateral') }}
                {{ Form::text('collateral', '', ['class' => 'form-control']) }}
            </div>
            <div class="form-group col-md-1">
                {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection