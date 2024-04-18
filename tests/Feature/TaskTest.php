<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_api_return_tasks_list(): void
    {
        $response = $this->get('/api/tasks');

        $response->assertStatus(200);
    }
}
