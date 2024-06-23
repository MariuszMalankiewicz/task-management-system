<?php

namespace Tests\Feature\Table;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTableTest extends TestCase
{
    use RefreshDatabase;

    public function test_tasks_database_has_expected_columns()
    {
        $this->assertTrue( 
          Schema::hasColumns('tasks', [
            'id','user_id', 'title', 'description', 'status'
        ]), 1);
    }
}
