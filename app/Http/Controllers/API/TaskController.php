<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Services\TaskService;

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
        return $this->taskService->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $taskRequest)
    {
        return $this->taskService->create($taskRequest);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return $this->taskService->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $taskRequest, int $id)
    {
        return $this->taskService->updateOrFail($id, $taskRequest);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        return $this->taskService->deleteOrFail($id);
    }
}
