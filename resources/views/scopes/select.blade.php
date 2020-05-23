@extends('layouts.b4')
@section('content')
<?php
    $publicData = false;
    $corpContracts = false;
?>
<div class="container">
    <h2>Select Scopes for ESI</h2>
    {!! Form::open(['action' => 'Auth\EsiScopeController@redirectToProvider', 'method' => 'POST']) !!}
        @foreach($scopes as $scope)
            @if($scope->scope == 'publicData')
                <div class="form-group col-md-6">
                    {{ Form::label('scopes[]', 'Public Data') }}
                    {{ Form::checkbox('scopes[]', 'publicData', 'true') }}
                </div>
                <?php $publicData = true; ?>
                @break
            @endif
        @endforeach       
        @foreach($scopes as $scope)
            @if($scope->scope == 'esi-contracts.read_corporation_contracts.v1')
                <div class="form-group col-md-6">
                    {{ Form::label('scopes[]', 'Corporate Contracts') }}
                    {{ Form::checkbox('scopes[]', 'esi-contracts.read_corporation_contracts.v1') }}
                </div>
                <?php $corpContracts = true; ?>
            @endif
        @endforeach

        @if($publicData == false)
        <div class="form-group col-md-6">
            {{ Form::label('scopes[]', 'Public Data') }}
            {{ Form::checkbox('scopes[]', 'publicData') }}
        </div>
        @endif
        @if($corpContracts == false)
        <div class="form-group col-md-6">
            {{ Form::label('scopes[]', 'Corporate Contracts') }}
            {{ Form::checkbox('scopes[]', 'esi-contracts.read_corporation_contracts.v1') }}
        </div>
        @endif
        {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
    {!! Form::close() !!}
</div>
@endsection