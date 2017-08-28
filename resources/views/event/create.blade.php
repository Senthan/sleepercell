@extends('layouts.app')
@section('title', 'Create event')
@section('content')
    <ul class="breadcrumb">
        <!-- <li>{!! link_to_route('home.index', 'Home ') !!}</li> -->
        <li>{!! link_to_route('event.index', 'Calendar') !!}</li>
        <li class="active">Create Event</li>
    </ul>
    {!! Form::open(['url' => route('event.store'), 'role' => 'form', 'class' => 'form-horizontal']) !!}
    <div class="panel panel-default">
        <div class="panel-heading">
            <a href="{{ route('event.index') }}" class="btn btn-default">Cancel</a>
        </div>
        <div class="panel-body">
            @include('event._form')
        </div>
        <div class="panel-footer">
        <button type="submit" class="btn btn-success">Create</button>
        <a href="{{ route('event.index') }}" type="button" class="btn btn-danger" data-dismiss="modal">Close</a>
        </div>
    </div>
    {!! Form::close() !!}
@endsection