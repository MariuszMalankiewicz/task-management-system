<?php

namespace App\Services;

use App\Models\Task;
use App\Http\Response\ApiResponse;
use App\Http\Resources\TaskResource;

class TaskService
{
    public function all()
    {
        $tasks = Task::all();

        return TaskResource::collection($tasks);
    }

    public function create(object $data)
    {
        $task = Task::create($data->validated());

        return new TaskResource($task);
    }

    public function find(int $id)
    {
        return Task::find($id);
    }

    public function fail($task)
    {
        return (new ApiResponse)->apiResponse('not found 404', $task, 404);
    }

    public function findOrFail(int $id)
    {
        $task = $this->find($id);

        if (!$task) 
        {
            return $this->fail($task);
        }

        return new TaskResource($task);
    }

    public function updateOrFail(int $id, object $request)
    {
        $task = $this->find($id);

        if (!$task) 
        {
            return $this->fail($task);
        }

        $task->update($request->validated());

        return new TaskResource($task);
    }

    public function deleteOrFail(int $id)
    {
        $task = $this->find($id);

        if (!$task) 
        {
            return $this->fail($task);
        }

        $task->delete();

        return (new ApiResponse)->apiResponse('successful delete', $task, 204);
    }
}