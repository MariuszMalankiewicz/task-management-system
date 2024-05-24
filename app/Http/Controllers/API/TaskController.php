<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Repositories\Task\TaskRepository;

class TaskController extends Controller
{
    public function __construct(protected TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->taskRepository->all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $taskRequest)
    {
        return $this->taskRepository->create($taskRequest);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return $this->taskRepository->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $taskRequest, int $id)
    {
        return $this->taskRepository->updateOrFail($taskRequest, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        return $this->taskRepository->destroyOrFail($id);
    }
}
