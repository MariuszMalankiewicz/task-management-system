<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_tasks_belongs_to_user()
    {
        $user = $this->user()->create();
        $task = $this->task()->create(['user_id' => $user->id]);

        $this->assertEquals(1, $task->user->count());
        $this->assertInstanceOf(User::class, $task->user->first());
    }
}
