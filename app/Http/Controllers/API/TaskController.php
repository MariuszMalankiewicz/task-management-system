<?php

namespace App\Http\Controllers\API;

use App\Services\TaskService;
use App\Http\Requests\TaskRequest;
use App\Http\Response\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = $this->taskService->all();

        return (new ApiResponse)->apiResponse('Status 200 OK', $tasks, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $taskRequest)
    {
        $task = $this->taskService->create($taskRequest);

        return (new ApiResponse)->apiResponse('Status 201 Created', $task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $task = $this->taskService->find($id);

        return $task ? (new ApiResponse)->apiResponse('Status 200 OK', $task, 200) : (new ApiResponse)->apiResponse('Status 404 Not Found', $task, 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $taskRequest, int $id)
    {
        $task = $this->taskService->updateOrFail($id, $taskRequest);

        return $task ? (new ApiResponse)->apiResponse('Status 200 OK', $task, 200) : (new ApiResponse)->apiResponse('Status 404 Not Found', $task, 404); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $task = $this->taskService->deleteOrFail($id);

        return $task ? (new ApiResponse)->apiResponse('successful delete', $task, 204) : (new ApiResponse)->apiResponse('Status 404 Not Found', $task, 404); 
    }
}