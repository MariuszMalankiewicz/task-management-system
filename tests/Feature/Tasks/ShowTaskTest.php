<?php

namespace Tests\Feature\Tasks;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowTaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_status_200_ok()
    {
        $user = $this->authUser();
        $task = $this->task()->create(['user_id' => $user->id]);

        $this->getJson(route('tasks.show', $task->id))
            ->assertOk();
    }

    public function test_show_a_single_task()
    {
        $user = $this->authUser();
        $task = $this->task()->create(['user_id' => $user->id]);

        $this->getJson(route('tasks.show', $task->id))
            ->assertJsonFragment([
                'data' => [
                    'id' => $task->id,
                    'title' => $task->title,
                    'description' => $task->description,
                    'status' => $task->status,
                    'created_at' => $task->created_at,
                    'updated_at' => $task->updated_at,
                    'user_id' => $task->user_id
                ]
            ]);
    }

    public function test_invalid_id_for_display_a_single_task()
    {
        $user = $this->authUser();
        $task = $this->task()->create(['user_id' => $user->id]);
        $invalidId = 2;

        $this->getJson(route('tasks.show', $invalidId))
            ->assertNotFound()
            ->assertJson([]);
    }
}