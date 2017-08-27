<?php

namespace App\Policies;

use App\Event;
use App\User;

class EventPolicy extends Policy
{
    protected $encrypted = [];

    protected $methods = ['index', 'create', 'edit', 'show', 'delete'];
    protected $replacedMethods = [
        'view' => 'show', 'update' => 'edit'
    ];
    public function index()
    {
        return $this->commonCheck;
    }

    public function create()
    {
        return $this->commonCheck;
    }

    public function store()
    {
        return $this->create();
    }

    public function edit(User $user, Event $event)
    {
        $eventType = $event->eventType()->first();
        if($eventType) {
            if(str_contains(strtolower($eventType->name), 'leave')) {
                return false;
            }
        }
        $staff = $user->staff()->first();
        if($event->isOwner($staff)) {
            return true;
        }
        return $this->commonCheck;
    }

    public function update(User $user, Event $event)
    {
        return $this->edit($user, $event);
    }

    public function show()
    {
        return $this->commonCheck;
    }

    public function view()
    {
        return $this->show();
    }

    public function delete(User $user, Event $event)
    {
        $eventType = $event->eventType()->first();
        if($eventType) {
            if(str_contains(strtolower($eventType->name), 'leave')) {
                return false;
            }
        }
        return $this->commonCheck;
    }

    public function destroy(User $user, Event $event)
    {
        return $this->delete($user, $event);
    }
}
