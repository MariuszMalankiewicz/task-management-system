<?php

namespace App\Services;

use App\Models\Task;
use Illuminate\Support\Facades\Gate;

class TaskService
{
    public function all()
    {
        return Task::all();
    }

    public function create(object $data)
    {
        return Task::create($data->validated());   
    }

    public function find(int $id)
    {
        return Task::find($id);
    }

    public function updateOrFail(int $id, object $request)
    {
        $task = $this->find($id);

        Gate::authorize('update', $task);

        if(!$task)
        {
            return null;
        }

        $task->update($request->validated());

        return $task;
    }

    public function deleteOrFail(int $id)
    {
        $task = $this->find($id);

        Gate::authorize('delete', $task);

        if(!$task)
        {
            return null;
        }

        return $task->delete();
    }
}