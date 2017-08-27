<?php

namespace App\Http\Controllers;

use App\Events\EventNotification;
use App\Repositories\EventRepository;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Event;
use App\EventType;
use App\Http\Requests\EventStoreRequest;
use App\Http\Requests\EventUpdateRequest;

class EventController extends Controller
{
    protected $event;

    public function __construct(EventRepository $event)
    {
        $this->event = $event;
    }

    public function index()
    {
        if (request()->ajax()) {
            return $this->event->retrieve(request()->only(['start', 'end']), request()->input('types'))->transform()->get();
        }
        $eventTypes = EventType::get();
        return view('event.index', compact('eventTypes'));
    }

    public function create()
    {
        $repeatValues = ['No' => 'No', 'Daily' => 'Daily', 'Weekly' => 'Weekly', 'Monthly' => 'Monthly', 'Yearly' => 'Yearly'];
        $start = request()->input('start', null);
        $end = request()->input('end', null);
        if(!$start) {
            $start = carbon()->now();
        } else {
            $start = carbon()->createFromTimestamp($start / 1000);
        }
        if(!$end) {
            $end = carbon()->now();
        } else {
            $end = carbon()->createFromTimestamp($end / 1000);
        }
        $eventTypes = EventType::get()->pluck('name', 'id');
        $userIds = collect([]);
        return view('event.create', compact('eventTypes', 'start', 'end', 'userIds', 'repeatValues'));
    }

    public function store(EventStoreRequest $request)
    {

        if($request->input('repeat_end') == '') {
            $request->merge(['repeat_end' => null]);
        }
        if($request->input('all_day') == null) {
            $request->merge(['all_day' => 'No']);
        }
        if($request->input('repeat_every') == '') {
            $request->merge(['repeat_every' => null]);
        }

        if($request->input('event_type_id') == 3) {
            $request->merge(['end' => $request->input('start')]);
        }



        $event = Event::create($request->only(['event_type_id', 'what', 'all_day', 'start', 'end', 'repeat', 'repeat_every', 'repeat_end', 'where', 'description']));
        if(count($request->input('user'))) {
            $userIDs = array_values(array_filter(explode(',', trim($request->input('user')[0], ' []'))));
            if(count($userIDs)) {
                $event->user()->attach($userIDs);
                if($request->input('event_type_id') == 3) {
                    $user = $event->user()->first();
                    $event->what = $user->short_name . ' BD';
                    $event->save();
                }
            }
        }

        return redirect()->route('event.index');
    }

    public function edit(Event $event)
    {
        $repeatValues = ['No' => 'No', 'Daily' => 'Daily', 'Weekly' => 'Weekly', 'Monthly' => 'Monthly', 'Yearly' => 'Yearly'];
        $event->start = $event->start->timezone(config('app.timezone'));
        $event->end = $event->end->timezone(config('app.timezone'));
        $start = null;
        $end = null;
        $event->user = $event->user()->get()->pluck('name', 'id');
        $userIds = implode(",", $event->user()->get()->pluck('id')->toArray());
        $eventTypes = EventType::pluck('name', 'id');
        return view('event.edit', compact('event', 'eventTypes', 'start', 'end', 'userIds', 'repeatValues'));
    }

    public function update(EventUpdateRequest $request, Event $event)
    {
        if($request->input('repeat_end') == '') {
            $request->merge(['repeat_end' => null]);
        }
        if($request->input('all_day') == null) {
            $request->merge(['all_day' => 'No']);
        }
        if($request->input('repeat_every') == '') {
            $request->merge(['repeat_every' => null]);
        }
        $event->update($request->only(['event_type_id', 'what', 'all_day', 'start', 'end', 'repeat', 'repeat_every', 'repeat_end', 'where', 'description']));
        if(count($request->input('user'))) {
            $userIDs = array_values(array_filter(explode(',', trim($request->input('user')[0], ' []'))));
            if(count($userIDs)) {
                $event->user()->detach();
                $event->user()->attach($userIDs);
            }
        }

        return redirect()->route('event.index');
    }
}
