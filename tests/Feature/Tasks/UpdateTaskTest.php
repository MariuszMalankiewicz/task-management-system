<?php

namespace Tests\Feature\tasks;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdatetaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_status_200_ok()
    {
        $user = $this->authUser();
        $task = $this->task()->create(['user_id' => $user->id]);

        $updatetask = [
            'title' => 'update title',
            'description' => 'update description',
            'status' => 'zamkniete',
            'user_id' => $user->id
        ];

        $this->putJson(route('tasks.update', $task->id), $updatetask)
            ->assertOk();
    }

    public function test_check_update_task_in_response_json()
    {
        $user = $this->authUser();
        $task = $this->task()->create(['user_id' => $user->id]);

        $updatetask = [
            'title' => 'update title',
            'description' => 'update description',
            'status' => 'zamkniete',
            'user_id' => $user->id
        ];

        $this->putJson(route('tasks.update', $task->id), $updatetask)
            ->assertJson([
                'data' => [
                    'title' => $updatetask['title'],
                    'description' => $updatetask['description'],
                    'status' => $updatetask['status'],
                ]
        ]);
    }

    public function test_database_has_updated_task()
    {
        $user = $this->authUser();
        $task = $this->task()->create(['user_id' => $user->id]);

        $updatetask = [
            'title' => 'update title',
            'description' => 'update description',
            'status' => 'zamkniete',
            'user_id' => $user->id
        ];

        $this->putJson(route('tasks.update', $task->id), $updatetask);

        $this->assertDatabaseHas('tasks', [
            'title' => $updatetask['title'],
            'description' => $updatetask['description'],
            'status' => $updatetask['status'],
            'user_id' => $updatetask['user_id'],
        ]);
    }
    
    public function test_database_count_updated_task()
    {
        $user = $this->authUser();
        $task = $this->task()->create(['user_id' => $user->id]);

        $updatetask = [
            'title' => 'update title',
            'description' => 'update description',
            'status' => 'zamkniete',
            'user_id' => $user->id
        ];

        $this->putJson(route('tasks.update', $task->id), $updatetask);

        $this->assertDatabaseCount('tasks', 1);
    }

    public function test_invalid_id_for_update_task()
    {
        $user = $this->authUser();
        $this->task()->create(['user_id' => $user->id]);

        $incorrectId = 2;

        $updatetask = [
            'title' => 'update title',
            'description' => 'update description',
            'status' => 'zamkniete',
            'user_id' => $user->id
        ];

        $this->putJson(route('tasks.update', $incorrectId), $updatetask)
            ->assertNotFound()
            ->assertJson([]);
    }

    public function test_field_is_required_for_update_task()
    {
        $user = $this->authUser();
        $task = $this->task()->create(['user_id' => $user->id]);

        $updatetask = $this->emptytask();

        $this->putJson(route('tasks.update', $task->id), $updatetask)
            ->assertUnprocessable()
            ->assertJson([
                'data' => array(
                    'title' => array('The title field is required.'),
                    'description' => array('The description field is required.'),
                    'status' => array('The status field is required.'),
                    'user_id' => array('The user id field is required.')
                )
            ]);
    }

    public function test_selected_status_is_invalid_for_update_task()
    {
        $user = $this->authUser();
        $task = $this->task()->create(['user_id' => $user->id]);

        $updatetask = [
            'status' => 'wrong status'
        ];

        $this->putJson(route('tasks.update', $task->id), $updatetask)
            ->assertUnprocessable()
            ->assertJson([
                'data' => array(
                    'status' => array('The selected status is invalid.')
                )
            ]);
    }
}
