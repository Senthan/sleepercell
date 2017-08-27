<div class="form-group">
    <div class="col-sm-2">
        <label for="eventType" class="col-sm-2 control-label">EventType</label>
    </div>
    <div class="col-sm-10">
        <select id="event_type_id" name="event_type_id" class="ui search fluid selection dropdown role-dropdown clearfix">
            <option value="">Select Event Type</option>
            @foreach($eventTypes as $key => $eventType)
                <option {{ isset($event) && $key == $event->event_type_id  ? 'selected' : '' }} value="{{ $key }}">{{ $eventType }}</option>
            @endforeach
        </select>
        <p class="help-block"> {!! ($errors->has('event_type_id') ? $errors->first('event_type_id') : '') !!}</p>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-2">
        <label for="what" class="col-sm-2 control-label">What</label>
    </div>
    <div class="col-sm-10">
        {!! Form::text('what', null, ['class' => "what col-md-12 form-control", 'placeholder' => 'What']) !!}
        <p class="help-block">{!! ($errors->has('what') ? $errors->first('what') : '') !!}</p>
    </div>
</div>

<div class="form-group ">
    <div class="col-sm-2">
        <label for="user" class="col-sm-2 control-label">User</label>
    </div>
    <div class="col-sm-10">
        <div class="ui fluid search selection dropdown multiple" id="ui_combo_staff">
            <input name="user[]" type="hidden" value="{{ $userIds  }}" id="user[]">
            <i class="dropdown icon"></i>
            @if(isset($event))
                @foreach($event->user as $key => $user)
                    <a class="ui label transition visible" data-value="{{ $key }}" style="display: inline-block !important;">{{ $user }}<i class="delete icon"></i></a>
                @endforeach
            @endif
            <div class="default text"></div>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-2">
        <label for="start" class="col-sm-2 control-label">Start</label>
    </div>
    <div class="col-sm-10">
         {!! Form::text('start', null, ['class' => "col-md-12 form-control date-time-picker", 'placeholder' => 'Start']) !!}
        <p class="help-block">{!! ($errors->has('start') ? $errors->first('start') : '') !!}</p>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-2">
        <label for="end" class="col-sm-2 control-label">End</label>
    </div>
    <div class="col-sm-10">
        {!! Form::text('end', null, ['class' => "col-md-12 form-control date-time-picker", 'placeholder' => 'End']) !!}
        <p class="help-block">{!! ($errors->has('end') ? $errors->first('end') : '') !!}</p>
    </div>
</div>


<div class="form-group">
    <div class="col-sm-2">
        <label for="repeat" class="col-sm-2 control-label">Repeat</label>
    </div>
    <div class="col-sm-10">
        <select id="repeat" name="repeat" class="ui search fluid selection dropdown repeat-dropdown clearfix">
            <option value="">Select Repeat</option>
            @foreach($repeatValues as $key => $value)
                <option {{ isset($event) && $key == $event->repeat  ? 'selected' : '' }} value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
        <p class="help-block"> {!! ($errors->has('repeat') ? $errors->first('repeat') : '') !!}</p>
    </div>
</div>


<div class="form-group">
    <div class="col-sm-2">
        <label for="repeat_every" class="col-sm-2 control-label">Repeat every</label>
    </div>
    <div class="col-sm-10">
        {!! Form::text('repeat_every', null, ['class' => "col-md-12 form-control", 'placeholder' => 'Repeat every']) !!}
        <p class="help-block">{!! ($errors->has('repeat_every') ? $errors->first('repeat_every') : '') !!}</p>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-2">
        <label for="repeat_end" class="col-sm-2 control-label">'Repeat end</label>
    </div>
    <div class="col-sm-10">
        {!! Form::text('repeat_end', null, ['class' => "col-md-12 form-control date-time-picker", 'placeholder' => 'Repeat end']) !!}
        <p class="help-block">{!! ($errors->has('repeat_end') ? $errors->first('repeat_end') : '') !!}</p>
    </div>
</div>

<div class="form-group">
    <div class="col-sm-2">
        <label for="eventType" class="col-sm-2 control-label">Description</label>
    </div>
    <div class="col-sm-10">
        {!! Form::textarea('description', null, ['class' => "what col-md-12 form-control", 'placeholder' => 'Description']) !!}
        <p class="help-block">{!! ($errors->has('description') ? $errors->first('description') : '') !!}</p>
    </div>
</div>

@section('script')
    @parent
    <script src="{{ asset('components/semantic/dist/semantic.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            var inEventType = $('#event_type_id');
            var inRepeatEvery = $('#repeat_every');
            var inRepeatEnd = $('#repeat_end');
            var inRepeat = $('#repeat');
            var inWhat = $('#what');
            var inStaff = $('#ui_combo_staff');
            var inAllDay = $('#all_day');
            var inStart = $('#start');
            var inEnd = $('#end');
            var inDescription = $('#description');
            var ddRepeat = inRepeat.dropdown();
            var ddEventType = inEventType.dropdown();

            var ddStaff = inStaff.dropdown('setting', {
                apiSettings: {
                    url: '{{ route('user.search') }}/{query}'
                }
            });

            console.log('ddStaff', ddStaff);
            function resetUI() {
                inDescription.parents('.form-group').hide();
                inWhat.parents('.form-group').show();
                inRepeatEvery.parents('.form-group').show();
                inRepeatEnd.parents('.form-group').show();
                inStaff.parents('.form-group').show();
                inAllDay.parents('.form-group').show();
                inEnd.parents('.form-group').show();
                inRepeat.parents('.form-group').show();

                repeatUI(inRepeat.val(), true);
                eventTypeUI(inEventType.val(), true);
            }
            resetUI();

            function eventTypeUI(eventType, doNotReset) {

                if(eventType == 2) {
                    {{--swal({--}}
                        {{--title: "Do you want to apply for leave?",--}}
                        {{--text: "",--}}
                        {{--type: "warning",--}}
                        {{--showCancelButton: true,--}}
                        {{--confirmButtonColor: "#5cb85c",--}}
                        {{--confirmButtonText: "Yes, I want!",--}}
                        {{--cancelButtonText: "No, cancel please!",--}}
                        {{--closeOnConfirm: true,--}}
                        {{--closeOnCancel: true--}}
                    {{--}, function (isConfirm) {--}}
                        {{--if (isConfirm) {--}}
                            {{--window.location = '{{ route('my-leave.create') }}';--}}
                        {{--}--}}
                    {{--});--}}
                }


                if(!doNotReset) {
                    resetUI();
                }
                // Birthdays
                if(eventType == 3) {
                    inWhat.parents('.form-group').hide();
                    inAllDay.parents('.form-group').hide();
                    inEnd.parents('.form-group').hide();
                    inRepeat.val('Yearly');
                    inRepeatEvery.val(1);
                    repeatUI(inRepeat.val(), true);
                    inStaff.removeClass('multiple');
                    inAllDay.attr('checked', true);
                    dateTimePicker.data("DateTimePicker").format('YYYY-MM-DD');
                } else {
                    inStaff.addClass('multiple');
                    dateTimePicker.data("DateTimePicker").format('YYYY-MM-DD H:mm:ss');
                }
                // Public holidays
                if(eventType == 5) {
                    inStaff.parents('.form-group').hide();
                    inAllDay.parents('.form-group').hide();
                    inEnd.parents('.form-group').hide();
                }
            }



            function repeatUI(status, doNotReset) {
                if(!doNotReset) {
                    resetUI();
                }
                if(status == 'No') {
                    inRepeatEvery.parents('.form-group').hide();
                    inRepeatEnd.parents('.form-group').hide();
                } else {
                    inRepeatEvery.parents('.form-group').show();
                    inRepeatEnd.parents('.form-group').show();
                }

            }
            function whereUI(status, doNotReset) {
                if(!doNotReset) {
                    resetUI();
                }
                if(status == 'g2w') {
                    inDescription.parents('.form-group').show();
                } else {
                    inDescription.parents('.form-group').hide();
                }

            }

            inEventType.change(function () {
                eventTypeUI($(this).val());
            });
            inRepeat.change(function () {
                repeatUI($(this).val());
            });

            $('.ui.checkbox').checkbox();

        });
    </script>
@endsection