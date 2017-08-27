<?php

namespace App\Transformers;

use App\Event;
use League\Fractal\TransformerAbstract;

class EventTransformer extends TransformerAbstract {

    public function transform(Event $event)
    {
        return [
            'id' => (int) $event->id,
            'title' => $event->what,
            'start' => $event->all_day == 'Yes' ? $event->start->timezone(config('app.timezone'))->toDateString() : $event->start->timezone(config('app.timezone'))->toDateTimeString(),
            'end' => $event->all_day == 'Yes' ? $event->end->timezone(config('app.timezone'))->toDateString() : $event->end->timezone(config('app.timezone'))->toDateTimeString(),
            'className' => 'calendar-event ui ' . $event->eventType->class . ' basic label',
        ];
    }
}