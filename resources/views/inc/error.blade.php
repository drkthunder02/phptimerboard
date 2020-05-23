@extends('layouts.b4')
@section('content')
<div class="container">
    <div class="card-header">
        Error
    </div>
    <div class="card-body">
    @foreach($errors as $error)
        <div class="alert alert-error" role="alert">
            You have encountered an error.<br>
            <?php printf($error); ?><br>
        </div>
    @endforeach
    </div>
</div>
@endsection