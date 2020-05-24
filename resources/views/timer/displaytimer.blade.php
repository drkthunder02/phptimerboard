@extends('layouts.b4')
@section('content')

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Type</th>
            <th>Stage</th>
            <th>Location</th>
            <th>Owner</th>
            <th>EVE Time</th>
            <th>Remaining</th>
            <th>Notes</th>
            <th>User</th>
        </tr>   
    </thead>
    <tbody>
        @if($timers != null)
        @foreach($timers as $timer)
        @if($timer->type == 'Defense')
        <tr class="warning">
            <td>{{ $timer->type }}</td>
            <td>{{ $timer->stage }}</td>
            @if($timer->moon == null)
            <td>{{ $timer->region . " - " . $timer->system . " - " . $timer->planet }}</td>
            @else
            <td>{{ $timer->region . " - " . $timer->system . " - " . $timer->planet . " - " . $timer->moon }}</td>
            @endif
            <td>{{ $timer->owner }}</td>
            <td>{{ $timer->eve_time }}</td>
            <td>{{ $timer->remaining }}</td>
            <td>{{ $timer->notes }}</td>
            <td>{{ $timer->user }}</td>
        </tr>
        @elseif($timer->type == 'Offensive')
        <tr class="danger">
            <td>{{ $timer->type }}</td>
            <td>{{ $timer->stage }}</td>
            @if($timer->moon == null)
            <td>{{ $timer->region . " - " . $timer->system . " - " . $timer->planet }}</td>
            @else
            <td>{{ $timer->region . " - " . $timer->system . " - " . $timer->planet . " - " . $timer->moon }}</td>
            @endif
            <td>{{ $timer->owner }}</td>
            <td>{{ $timer->eve_time }}</td>
            <td>{{ $timer->remaining }}</td>
            <td>{{ $timer->notes }}</td>
            <td>{{ $timer->user }}</td>
        </tr>
        @elseif($timer->type == 'Fuel')
        <tr class="info">
            <td>{{ $timer->type }}</td>
            <td>{{ $timer->stage }}</td>
            @if($timer->moon == null)
            <td>{{ $timer->region . " - " . $timer->system . " - " . $timer->planet }}</td>
            @else
            <td>{{ $timer->region . " - " . $timer->system . " - " . $timer->planet . " - " . $timer->moon }}</td>
            @endif
            <td>{{ $timer->owner }}</td>
            <td>{{ $timer->eve_time }}</td>
            <td>{{ $timer->remaining }}</td>
            <td>{{ $timer->notes }}</td>
            <td>{{ $timer->user }}</td>
        </tr>
        @endif
        @endforeach
        @else
        <tr>
            <td>N/A</td>
            <td>N/A</td>
            <td>N/A</td>
            <td>N/A</td>
            <td>N/A</td>
            <td>N/A</td>
            <td>N/A</td>
            <td>N/A</td>
        </tr>
        @endif
    </tbody>
</table>

<script>
let timer = function(date) {
    let timer = Math.round(new Date(date).getTime()/1000) - Math.round(new Date().getTime()/1000);
		let minutes, seconds;
		setInterval(function () {
            if (--timer < 0) {
				timer = 0;
			}
			days = parseInt(timer / 60 / 60 / 24, 10);
			hours = parseInt((timer / 60 / 60) % 24, 10);
			minutes = parseInt((timer / 60) % 60, 10);
			seconds = parseInt(timer % 60, 10);

			days = days < 10 ? "0" + days : days;
			hours = hours < 10 ? "0" + hours : hours;
			minutes = minutes < 10 ? "0" + minutes : minutes;
			seconds = seconds < 10 ? "0" + seconds : seconds;

            document.getElementById('remaining').innerHTML = days . "D " . hours . "H " . minutes . "M " . seconds ."s"

			//document.getElementById('cd-days').innerHTML = days;
			//document.getElementById('cd-hours').innerHTML = hours;
			//document.getElementById('cd-minutes').innerHTML = minutes;
			//document.getElementById('cd-seconds').innerHTML = seconds;
		}, 1000);
	}
}

//Using the function
const today = new Date()
const tomorrow = new Date(today)
tomorrow.setDate(tomorrow.getDate() + 1)
timer(tomorrow);
</script>
<span id="cd-days">00</span> Days 
<span id="cd-hours">00</span> Hours
<span id="cd-minutes">00</span> Minutes
<span id="cd-seconds">00</span> Seconds
@endsection