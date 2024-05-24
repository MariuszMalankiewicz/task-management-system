<?php

namespace App\Repositories\Task;

use App\Models\Task;
use App\Http\Resources\TaskResource;

class TaskRepository implements TaskRepositoryInterface
{
    public function all()
    {
        $tasks = Task::all();

        return TaskResource::collection($tasks);
    }

    public function create(object $task)
    {
        $task = Task::create($task->all());

        return new TaskResource($task);
    }

    public function find(int $id)
    {
        return Task::find($id);
    }

    public function fail(int $code = 404)
    {
        return response()->json(null, $code);
    }

    public function findOrFail($id)
    {
        $task = $this->find($id);

        if (!$task) 
        {
            return $this->fail();
        }

        return new TaskResource($task);
    }

    public function update($request, $task)
    {
        $task->update($request->all());

        return new TaskResource($task);
    }

    public function updateOrFail($request, int $id)
    {
        $task = $this->find($id);

        if(!$task)
        {
            return $this->fail();
        }

        return $this->update($request, $task);
    }

    public function destroyOrFail(int $id)
    {
        $task = $this->find($id);

        if(!$task)
        {
            return $this->fail();
        }

        $task->delete();

        return $this->fail(204);
    }
}