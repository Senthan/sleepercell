@if(isset($eventType) && $eventType->readonly == 'Yes')
    <div class="form-group">
        <div class="col-sm-2">
            <label for="name" class="col-sm-2 control-label">'Name</label>
        </div>
        <div class="col-sm-10">
            {!! Form::text('name', null, ['class' => "col-md-12 form-control", 'placeholder' => 'Name', 'readonly' => true]) !!}
            <p class="help-block">{!! ($errors->has('name') ? $errors->first('name') : '') !!}</p>
        </div>
    </div>
@else
    <div class="form-group">
        <div class="col-sm-2">
            <label for="name" class="col-sm-2 control-label">'Name</label>
        </div>
        <div class="col-sm-10">
            {!! Form::text('name', null, ['class' => "col-md-12 form-control", 'placeholder' => 'Name']) !!}
            <p class="help-block">{!! ($errors->has('name') ? $errors->first('name') : '') !!}</p>
        </div>
    </div>
@endif

<div class="form-group">
    <div class="col-sm-2">
        <label for="class" class="col-sm-2 control-label">Class</label>
    </div>
    <div class="col-sm-10">
        <select id="class" name="class" class="ui search fluid selection dropdown class-dropdown clearfix">
            <option value="">Select Class</option>
            @foreach($classes as $key => $value)
                <option {{ isset($event) && $key == $event->class  ? 'selected' : '' }} value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        <p class="help-block"> {!! ($errors->has('class') ? $errors->first('class') : '') !!}</p>
    </div>
</div>