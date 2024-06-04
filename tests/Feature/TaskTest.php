<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_return_empty_structure_tasks_list(): void
    {
        $this->getjson(route('tasks.index'))
            ->assertOk()
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

    public function test_store_successful_task()
    {
        $task = $this->makeTask()->toArray();

        $this->postJson(route('tasks.store'), $task)
            ->assertCreated();

        $this->assertDatabaseHas('tasks', [
            'title' => $task['title'],
            'description' => $task['description'],
            'status' => $task['status']
        ]);
    }

    public function test_return_fragment_task_list(): void
    {
        $task = $this->createTask();

        $this->getjson(route('tasks.index'))
            ->assertOk()
            ->assertJsonFragment([
                'data' => [ 
                    array(
                        'id' => $task->id,
                        'title' => $task->title,
                        'description' => $task->description,
                        'status' => $task->status,
                        'created_at' => $task->created_at,
                        'updated_at' => $task->updated_at
                    )]
            ]);
    }

    public function test_field_is_required_for_store_task()
    {
        $task = $this->emptyTask();

        $this->postJson(route('tasks.store'), $task)
            ->assertUnprocessable()
            ->assertJson([
                'data' => array(
                    'title' => array('The title field is required.'),
                    'description' => array('The description field is required.'),
                    'status' => array('The status field is required.')
                )
            ]);
    }

    public function test_invalid_validation_rules_for_status()
    {
        $task = [
            'title' => 'title test',
            'description' => 'description test',
            'status' => 'wrong data'
        ];

        $this->postJson(route('tasks.store'), $task)
            ->assertUnprocessable()
            ->assertJson([
                'data' => array(
                    'status' => array('The selected status is invalid.')
                )
            ]);
    }

    public function test_show_a_single_task()
    {
        $task = $this->createTask();

        $this->getJson(route('tasks.show', $task->id))
            ->assertOk()
            ->assertJsonFragment([
                'data' => [
                    'id' => $task['id'],
                    'title' => $task['title'],
                    'description' => $task['description'],
                    'status' => $task['status'],
                    'created_at' => $task['created_at'],
                    'updated_at' => $task['updated_at']
                ]
            ]);
    }

    public function test_invalid_id_for_show_a_single_task()
    {
        $invalidId = 2;

        $this->getJson(route('tasks.show', $invalidId))
            ->assertNotFound()
            ->assertJson([]);
    }

    public function test_update_successful_a_single_task()
    {
        $task = $this->createTask();

        $updateTask = [
            'title' => 'update title',
            'description' => 'update description',
            'status' => 'zamkniete',
        ];

        $this->putJson(route('tasks.update', $task->id), $updateTask)
            ->assertOk()
            ->assertJson([
                'data' => [
                    'title' => $updateTask['title'],
                    'description' => $updateTask['description'],
                    'status' => $updateTask['status']
                ]
        ]);
    }

    public function test_invalid_id_for_update_task()
    {
        $task = $this->createTask();

        $incorrectId = 2;

        $updateTask = [
            'title' => 'update title',
            'description' => 'update description',
            'status' => 'zamkniete'
        ];

        $this->putJson(route('tasks.update', $incorrectId), $updateTask)
            ->assertNotFound()
            ->assertJson([]);
    }

    public function test_field_is_required_for_updated()
    {
        $task = $this->createTask();

        $updateTask = $this->emptyTask();

        $this->putJson(route('tasks.update', $task->id), $updateTask)
            ->assertUnprocessable()
            ->assertJson([
                'data' => array(
                    'title' => array('The title field is required.'),
                    'description' => array('The description field is required.'),
                    'status' => array('The status field is required.')
                )
            ]);
    }

    public function test_selected_status_is_invalid_for_update_task()
    {
        $task = $this->createTask();

        $updateTask = [
            'status' => 'wrong status'
        ];

        $this->putJson(route('tasks.update', $task->id), $updateTask)
            ->assertUnprocessable()
            ->assertJson([
                'data' => array(
                    'status' => array('The selected status is invalid.')
                )
            ]);
    }

    public function test_delete_successful_task()
    {
        $task = $this->createTask();

        $this->deleteJson(route('tasks.destroy', $task->id), [$task])
            ->assertNoContent();
        
        $this->assertDatabaseMissing('tasks', [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'status' => $task->status,
                'created_at' => $task->created_at,
                'updated_at' => $task->updated_at,
            ]);
    }

    public function test_invalid_id_for_delete_a_single_task()
    {
        $task = $this->createTask()->toArray();

        $incorrectId = 9999;

        $this->deleteJson(route('tasks.destroy', $incorrectId), $task)
            ->assertNotFound();
    }

}