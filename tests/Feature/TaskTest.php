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

    public function test_api_return_tasks_list(): void
    {
        Task::factory()->create();

        $response = $this->getjson('/api/tasks');

        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
    }

    public function test_api_check_save_data()
    {
        $task = Task::factory()->create();

        $response = $this->postJson('/api/tasks', [
            'id' => $task->id,
            'title' => $task->title,
            'description' => $task->description,
            'status' => $task->status,
            'created_at' => $task->created_at,
            'updated_at' => $task->updated_at
        ]);

        $response->assertStatus(201);
        $response->assertJsonCount(6, 'data');
    }

    public function test_api_invalid_validation_required()
    {
        $task = [
            'title' => '',
            'description' => ''
        ];

        $response = $this->postJson('/api/tasks', $task);

        $response->assertStatus(422);
        $response->assertInvalid([
            'title' => 'The title field is required.',
            'description' => 'The description field is required.'
        ]);

    }

    public function test_api_show_a_single_task()
    {
        $task = Task::factory()->create();

        $response = $this->getJson('/api/tasks/' . $task->id);

        $response->assertStatus(200);
        $response->assertJsonCount(6, 'data');

    }

    public function test_api_doesnt_show_a_single_task()
    {
        $response = $this->getJson('/api/tasks/1');

        $response->assertStatus(404);
    }

    public function test_api_update_a_single_task()
    {
        $task = Task::factory()->create();

        $updateTask = [
            'title' => 'update title',
            'description' => 'update description',
        ];

        $response = $this->putJson('/api/tasks/' . $task->id, $updateTask);
        
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'title' => $updateTask['title'],
                'description' => $updateTask['description'],
            ]
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

        $incorrectId = 2;

        $updateTask = [
            'title' => 'update title',
            'description' => 'update description',
        ];

        $response = $this->putJson('/api/tasks/' . $incorrectId, $updateTask);
        
        $response->assertStatus(404);
    }

    public function test_api_task_value_is_required_for_update()
    {
        $task = Task::factory()->create();

        $updateTask = [
            'title' => '',
            'description' => ''
        ];

        $response = $this->putJson('/api/tasks/' . $task->id, $updateTask);

        $response->assertStatus(422);
        $response->assertInvalid([
            'title' => 'The title field is required.',
            'description' => 'The description field is required.'
        ]);
    }

    public function test_api_deleted_a_task_success()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson('api/tasks/' . $task->id, [$task]);

        $response->assertStatus(204);
    }

    public function test_api_incorrect_identification_of_the_task_to_delete()
    {
        // factory created id = 1
        $task = Task::factory()->create();
        $incorrectId = 9999;

        $response = $this->deleteJson('/api/tasks/' . $incorrectId, [$task]);

        $response->assertStatus(404);
    }
}
