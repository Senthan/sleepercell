@extends('layouts.app')
@section('title', 'Edit a office')
@section('content')
    <ul class="breadcrumb">
{{--        <li>{!! link_to_route('home.index', 'Home ') !!}</li>--}}
        <li>{!! link_to_route('event.index', 'Calendar') !!}</li>
        <li class="active">Update Event Type</li>
    </ul>
    {!! Form::model($eventType, ['url' => route('eventType.update', ['eventType' => $eventType->id]), 'method' => 'PATCH']) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <a href="{{ route('event.index') }}" class="btn btn-default">Calendar</a>
        </div>
        <div class="panel-body">
            @include('event.type._form')
        </div>
        <div class="panel-footer">
            <button type="submit" class="btn btn-info">Update</button>
            <a href="{{ route('event.index') }}" type="button" class="btn btn-danger" data-dismiss="modal">Close</a>
        </div>
    </div>
    {!! Form::close() !!}
@endsection