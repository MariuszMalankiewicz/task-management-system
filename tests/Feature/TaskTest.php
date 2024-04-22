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

    public function test_api_invalid_validation_required()
    {
        $task = [
            'title' => '',
            'description' => '',
        ];

        $response = $this->postJson('/api/tasks', $task);

        $response->assertInvalid(['title', 'description']);
        $response->assertStatus(422);
        $this->assertDatabaseMissing('tasks', $task);
    }

    public function test_api_show_a_single_task()
    {
        $task = [
            'id' => 1,
            'title' => 'title',
            'description' => 'description',
        ];

        Task::create($task);

        $response = $this->getJson('/api/task/1');

        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', $task);

    }

    public function test_api_doesnt_show_a_single_task()
    {
        $response = $this->getJson('/api/task/1');

        $response->assertStatus(404);
        $this->assertDatabaseMissing('tasks', ['id' => 2]); 
    }

    public function test_api_update_a_single_task()
    {
        $task = [
            'id' => 1,
            'title' => 'title',
            'description' => 'description',
        ];

        Task::create($task);

        $updateTask = [
            'id' => 1,
            'title' => 'update title',
            'description' => 'update description',
        ];

        $response = $this->putJson('/api/tasks/1', $updateTask);
        
        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks',
            [
                'id' => $updateTask['id'],
                'title' => $updateTask['title'],
                'description' => $updateTask['description'],
            ]);
    }

    public function test_api_incorrect_identification_of_the_task_to_be_update()
    {
        $task = [
            'id' => 1,
            'title' => 'title',
            'description' => 'description',
        ];

        Task::create($task);

        $updateTask = [
            'id' => 2,
            'title' => 'update title',
            'description' => 'update description',
        ];

        $response = $this->putJson('/api/tasks/5', $updateTask);
        
        $response->assertStatus(404);
        $this->assertDatabaseMissing('tasks',
            [
                'id' => $updateTask['id'],
                'title' => $updateTask['title'],
                'description' => $updateTask['description'],
            ]);
    }

    public function test_api_task_value_is_required_for_update()
    {
        $task = [
            'id' => 1,
            'title' => 'title',
            'description' => 'description'
        ];

        Task::create($task);

        $updateTask = [
            'id' => 2,
            'title' => '',
            'description' => ''
        ];

        $response = $this->putJson('/api/tasks/1', $updateTask);

        $response->assertStatus(422);
        $this->assertDatabaseMissing('tasks', [
            'id' => $updateTask['id'],
            'title' => $updateTask['title'],
            'description' => $updateTask['description'],
        ]);
    }
}
