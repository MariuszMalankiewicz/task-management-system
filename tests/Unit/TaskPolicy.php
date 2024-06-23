<?php

namespace Tests\Unit;

use App\Policies\TaskPolicy as PoliciesTaskPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskPolicy extends TestCase 
{
    use RefreshDatabase;

    public function test_user_can_update_task()
    {
        $user = $this->authUser();
        $task = $this->task()->create(['user_id' => $user->id]);
        
        $this->assertTrue((new PoliciesTaskPolicy)->update($user, $task));
    }

    public function test_user_cannot_update_task()
    {
        $user = $this->authUser();
        $task = $this->task()->create(['user_id' => $user->id]);
        $otherUser = $this->authUser();
        
        $this->assertFalse((new PoliciesTaskPolicy)->update($otherUser, $task));
    }

    public function test_user_can_delete_task()
    {
        $user = $this->authUser();
        $task = $this->task()->create(['user_id' => $user->id]);
        
        $this->assertTrue((new PoliciesTaskPolicy)->delete($user, $task));
    }

    public function test_user_cannot_delete_task()
    {
        $user = $this->authUser();
        $task = $this->task()->create(['user_id' => $user->id]);
        $otherUser = $this->authUser();
        
        $this->assertFalse((new PoliciesTaskPolicy)->delete($otherUser, $task));
    }
}

