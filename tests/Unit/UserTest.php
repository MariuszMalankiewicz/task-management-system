<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_many_tasks()
    {
        $user = $this->user()->create();
        $task = $this->task()->create(['user_id' => $user->id]);

        $this->assertTrue($user->tasks->contains($task));
        $this->assertEquals(1, $user->tasks->count());
        $this->assertInstanceOf(Task::class, $user->tasks->first());
    }
}
