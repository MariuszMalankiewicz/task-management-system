<?php

namespace App\Services;

use App\Models\Task;

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

        if(!$task)
        {
            return null;
        }

        return $task->delete();
    }
}