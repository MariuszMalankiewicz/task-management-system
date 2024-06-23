<?php

namespace Tests\Feature\tasks;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StoretaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_status_201_created()
    {
        $user = $this->authUser();
        $task = $this->task()->make(['user_id' => $user->id])->toArray();

        $this->postJson(route('tasks.store'), $task)
            ->assertCreated();
    }

    public function test_database_has_saved_task()
    {
        $user = $this->authUser();
        $task = $this->task()->make(['user_id' => $user->id])->toArray();

        $this->postJson(route('tasks.store'), $task);

        $this->assertDatabaseHas('tasks', [
            'title' => $task['title'],
            'description' => $task['description'],
            'status' => $task['status'],
            'user_id' => $task['user_id'],
        ]);
    }

    public function test_database_count_saved_task()
    {
        $user = $this->authUser();
        $task = $this->task()->make(['user_id' => $user->id])->toArray();

        $this->postJson(route('tasks.store'), $task);

        $this->assertDatabaseCount('tasks', 1);
    }

    
    public function test_status_422_Unprocessable()
    {
        $this->authUser();
        $task = $this->emptytask();

        $this->postJson(route('tasks.store'), $task)
            ->assertUnprocessable();
    }

    public function test_form_fields_is_required_for_save_task()
    {
        $this->authUser();
        $task = $this->emptytask();

        $this->postJson(route('tasks.store'), $task)
            ->assertJson([
                'data' => array(
                    'title' => array('The title field is required.'),
                    'description' => array('The description field is required.'),
                    'status' => array('The status field is required.'),
                    'user_id' => array('The user id field is required.')
                )
            ]);
    }

    public function test_invalid_validation_rules_for_status_field()
    {
        $user = $this->authUser();
        $task = [
            'title' => 'title test',
            'description' => 'description test',
            'status' => 'wrong data',
            'status' => $user->id
        ];

        $this->postJson(route('tasks.store'), $task)
            ->assertJson([
                'data' => array(
                    'status' => array('The selected status is invalid.')
                )
            ]);
    }
}