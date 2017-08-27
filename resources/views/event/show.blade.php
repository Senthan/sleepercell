@extends('admin.layouts.master')
@section('title', 'Edit event')
@section('content')
    <ul class="breadcrumb">
        <li>{!! link_to_route('home.index', 'Home ') !!}</li>
        <li>{!! link_to_route('event.index', 'Calendar') !!}</li>
        <li class="active">Details of Event</li>
    </ul>

    <div class="ui piled segments">
        <div class="ui {{ $event->eventType->class }} segment">
            <a href="{{ route('event.index') }}" class="btn btn-sm btn-default">Calendar</a>
            @can('edit', $event)
                <a href="{{ route('event.edit', ['event' => $event->id]) }}" class="btn btn-sm btn-info">Edit</a>
            @endcan
        </div>
        <div class="ui segment">
            <div class="ui {{ $event->eventType->class }} segment">
                {{ $event->what }} - {{ $event->eventType->name }}
            </div>
            <table class="table table-bordered">
                <tr>
                    <th>Start</th>
                    <td>{{ $event->start }}</td>
                </tr>
                <tr>
                    <th>End</th>
                    <td>{{ $event->end }}</td>
                </tr>
                <tr>
                    <th>All Day</th>
                    <td>{{ $event->all_day }}</td>
                </tr>
                <tr>
                    <th>Repeat</th>
                    <td>{{ $event->repeat }}</td>
                </tr>
                <tr>
                    <th>Repeat Every</th>
                    <td>{{ $event->repeat_every }}</td>
                </tr>
                <tr>
                    <th>Repeat End</th>
                    <td>{{ $event->repeat_end }}</td>
                </tr>
                <tr>
                    <th>Where</th>
                    <td>{{ $event->where }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $event->description }}</td>
                </tr>
            </table>

            @if($meeting)
            <div class="ui {{ $event->eventType->class }} segment">
                <table class="table table-bordered">
                    <tr>
                        <th>Subject</th>
                        <td>{{ $meeting->subject }}</td>
                    </tr>
                    <tr>
                        <th>URL</th>
                        <td><a href="https://global.gotomeeting.com/join/{{ $meeting->remote_id }}">https://global.gotomeeting.com/join/{{ $meeting->remote_id }}</a></td>
                    </tr>
                </table>
                @if($staff)
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Attendees</th>
                        <th>Local time</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($staff as $tz => $staffCollection)
                        <tr>
                            <td>
                                {{ $staffCollection->implode('short_name', ', ') }}
                            </td>
                            <td>
                                {{ $meeting->start_time->timezone($tz)->format('M j, Y \\a\\t h:i A') }} ({{ $tz }})
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @endif
            </div>
            @endif
        </div>
    </div>
@endsection