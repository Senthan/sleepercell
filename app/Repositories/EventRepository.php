<?php

namespace App\Repositories;


use App\Event;
use App\Transformers\EventTransformer;
use Illuminate\Support\Facades\Cache;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\DataArraySerializer;
use Recurr\Rule;
use Recurr\Transformer\ArrayTransformer;

class EventRepository
{
    private $event;

    public function retrieve(array $range = [], $types = '', Event $event = null)
    {
        $eventTypeIds = collect(array_values(array_filter(explode(',', $types))));
        if($event) {
            $events = collect([$event]);
        } else {
            $event = new Event();
            if(count($eventTypeIds->count())) {
                $eventTypeIds->transform(function($id) {
                    return (int) $id;
                })->toArray();
                $event = $event->whereIn('event_type_id', $eventTypeIds);
            }
            if(count($range)) {
                $event->where(function ($query) use($range) {
                    $query->whereBetween('start', $range)->orWhere('repeat', '!=', 'No');
                });
            }
            $events = $event->get();
        }
        $count = 20;
        foreach ($events as $event) {
            if($event->repeat != 'No') {
                $startDateRange = carbon()->createFromTimestamp(strtotime($range['start']));
                if($startDateRange->lt($event->start)) {
                    $startDateRange = $event->start;
                }
                if($event->repeat == 'Weekly') {
                    $event->start = $event->start->addWeeks($event->start->diffInWeeks($startDateRange));
                    $event->end = $event->end->addWeeks($event->end->diffInWeeks($startDateRange));
                }
                if($event->repeat == 'Monthly') {
                    $event->start = $event->start->addMonths($event->start->diffInMonths($startDateRange));
                    $event->end = $event->end->addMonths($event->end->diffInMonths($startDateRange));
                }
                if($event->repeat == 'Yearly') {
                    $event->start = $event->start->addYears($event->start->diffInYears($startDateRange));
                    $event->end = $event->end->addYears($event->end->diffInYears($startDateRange));
                }

                $rule = new Rule('FREQ=' . $event->repeat . ';COUNT=' . $count, $event->start, $event->end, config('app.timezone'));
                $transformer = new ArrayTransformer();
                $recurrences = $transformer->transform($rule);
                foreach ($recurrences as $i => $recurrence) {
                    if($i == 0) {
                        continue;
                    }
                    if($event->repeat_end && $event->repeat_end->lt(carbon($recurrence->getStart()->format(DATE_ISO8601)))) {
                        break;
                    }
                    $eve = $event->replicate();
                    $eve->id = $event->id;
                    $eve->start = $recurrence->getStart();
                    $eve->end = $recurrence->getEnd();
                    $events->push($eve);
                }
            }
        }
        $this->event = $events;
        return $this;
    }
    
    public function transform($event = null)
    {
        if(isset($event) && $event != null){
            $this->event = $event;
            $resource = new Item($this->event, new EventTransformer());
        }else{
            if(!$this->event) {
                $this->retrieve();
            }
            $resource = new Collection($this->event, new EventTransformer());
        }

        $manager = new Manager();
        $manager->setSerializer(new DataArraySerializer());
        $this->event = $manager->createData($resource)->toArray()['data'];

        return $this;
    }

    public function get()
    {
        if(!$this->event) {
            $this->retrieve();
        }
        return $this->event;
    }
}