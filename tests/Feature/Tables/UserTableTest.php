<?php

namespace Tests\Feature\Table;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;


class UserTableTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_database_has_expected_columns()
    {
        $this->assertTrue( 
          Schema::hasColumns('users', [
            'id', 'name', 'email', 'password'
        ]), 1);
    }
}
