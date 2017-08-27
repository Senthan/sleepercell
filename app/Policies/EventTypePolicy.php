<?php

namespace App\Policies;


use App\User;

class EventTypePolicy extends Policy
{
    protected $encrypted = [];

    protected $methods = ['index', 'create', 'edit', 'show', 'delete', 'deleteOwn'];
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

    public function edit()
    {
        return $this->commonCheck;
    }

    public function update()
    {
        return $this->edit();
    }

    public function show()
    {
        return $this->commonCheck;
    }

    public function view()
    {
        return $this->show();
    }

    public function delete(User $user, $model)
    {
        if($this->commonCheck) {
            return true;
        } else {
            return gate()->allows('deleteOwn', $model);
        }
    }

    public function destroy(User $user, $model)
    {
        return $this->delete($user, $model);
    }

    public function deleteOwn(User $user, $model)
    {
        return parent::deleteOwnObject($user, $model);
    }
}
