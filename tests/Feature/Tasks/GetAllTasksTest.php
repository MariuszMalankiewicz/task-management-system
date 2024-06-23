<?php

namespace Tests\Feature\Tasks;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetAllTasksTest extends TestCase
{
    use RefreshDatabase;

    public function test_status_200_ok()
    {
        $this->authUser();

        $this->getjson(route('tasks.index'))
            ->assertOk();
    }

    public function test_empty_structure_tasks_list(): void
    {
        $this->authUser();

        $this->getjson(route('tasks.index'))
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
                        'status',
                        'created_at',
                        'update_at',
                    ]
                ]
        ]);
    }

    public function test_fragment_task_list(): void
    {
        $user = $this->authUser();
        $task = $this->task()->create(['user_id' => $user->id]);

        $this->getjson(route('tasks.index'))
            ->assertJsonFragment([
                'message' => 'Status 200 OK',
                'data' => [
                    array(
                    'id' => $task->id,
                    'title' => $task->title,
                    'description' => $task->description,
                    'status' => $task->status,
                    'created_at' => $task->created_at,
                    'updated_at' => $task->updated_at,
                    'user_id' => $task->user_id
                    )
                ],
            ]);
    }
}
