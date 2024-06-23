<?php

namespace Tests;

use App\Models\Task;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function task()
    {
        return Task::factory();
    }

    public function emptyTask()
    {
        return [
            'title' => '',
            'description' => '',
            'status' => '',
            'user_id' => '',
        ];
    }

    public function user()
    {
        return User::factory();
    }

    public function emptyUser()
    {
        return [
            'name' => '',
            'email' => '',
            'password' => '',
        ];
    }

    public function authUser()
    {
        $user = $this->User()->create();
        Sanctum::actingAs($user);

        return $user;
    }
}
