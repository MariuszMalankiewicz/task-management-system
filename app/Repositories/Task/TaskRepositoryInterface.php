<?php

namespace App\Repositories\Task;

interface TaskRepositoryInterface
{
    public function all();

    public function create(object $task);

    public function find(int $id);

    public function fail(int $code);

    public function findOrFail($id);

    public function update($request, $task);

    public function updateOrFail($request, int $id);

    public function destroyOrFail(int $id);
}