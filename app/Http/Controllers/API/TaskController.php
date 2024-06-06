<?php

namespace App\Http\Controllers\API;

use App\Models\Task;
use App\Http\Requests\TaskRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();

        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $taskRequest)
    {
        $task = Task::create($taskRequest->validated());

        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $task = Task::find($id);

        if (!$task) 
        {
            return response()->json(null, 404);
        }

        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $taskRequest, int $id)
    {
        $task = Task::find($id);

        if (!$task) 
        {
            return response()->json(null, 404);
        }

        $task->update($taskRequest->validated());

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $task = Task::find($id);

        if (!$task) 
        {
            return response()->json(null, 404);
        }

        $task->delete();

        return response()->json(null, 204);
    }
}
