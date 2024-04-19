<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_return_empty_tasks_list(): void
    {
        $response = $this->getjson('/api/tasks');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'tasks' => [
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

    public function test_api_return_tasks_list(): void
    {
        $taskData = [
            'title' => 'test title',
            'description' => 'test description',
            'status' => 'test status'
        ];

        Task::create($taskData);

        $response = $this->getjson('/api/tasks');

        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', $taskData);
    }

    public function test_api_check_save_data()
    {
        $task = [
            'title' => 'test title',
            'description' => 'test description',
            'status' => 'test status'
        ];

        $response = $this->postJson('/api/tasks', $task);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', $task);
    }
}
