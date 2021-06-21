<form action="{{ route('logs.getLogs') }}" method="GET">
    <input type="date" name="date" value="{{ isset($date) ? $date->format('Y-m-d') : today()->format('Y-m-d') }}" />
    <input type="submit" value="Submit" />
</form> 

@if (empty($data['file']))
    <div>
        <h3>No Logs file</h3>
    </div>
@else
    <div>
        <h5> Updated on: <b>{{ $data['lastModified']->format('Y-m-d') }}</b> </h5>
        <h5> File size: <b>{{ round($data['size']) / 1024 }} Kb</b> </h5>

        <pre>{{ $data['file'] }}</pre>
    </div>

@endif