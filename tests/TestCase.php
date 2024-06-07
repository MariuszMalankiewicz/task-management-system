<?php

namespace Tests;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    
    /***
        methods for task
    ***/

    public function makeTask()
    {
        return Task::factory()->make();
    }

    public function createTask()
    {
        return Task::factory()->create();
    }

    public function emptyTask()
    {
        return [
            'title' => '',
            'description' => '',
            'status' => '',
        ];
    }

    /***
        methods for user/auth
    ***/

    public function createUser()
    {
        return User::factory()->create()->makeVisible('password');
    }

    public function makeUser()
    {
        return User::factory()->make()->makeVisible('password');
    }

    public function emptyUser()
    {
        return [
            'name' => '',
            'email' => '',
            'password' => '',
        ];
    }
}
