<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_user_successful(): void
    {
        $user = $this->makeUser()->toArray();

        $this->postJson(route('users.store'), $user)
            ->assertCreated();

        $this->assertDatabaseHas('users', [
            'name' => $user['name'],
            'email' => $user['email'],
        ]);
    }

    public function test_fields_is_required()
    {
        $user = $this->emptyUser();

        $this->postJson(route('users.store'), $user)
            ->assertUnprocessable()
            ->assertJson([
                array(
                    'name' => array('The name field is required.'),
                    'email' => array('The email field is required.'),
                    'password' => array('The password field is required.')
                    )
        ]);
    }

    public function test_name_and_email_field_is_unique()
    {
        $user = $this->createUser()->toArray();

        $this->postJson(route('users.store'), $user)
            ->assertUnprocessable()
            ->assertJson([
                array(
                    'name' => array('The name has already been taken.'),
                    'email' => array('The email has already been taken.')
                ),
            ]);
    }

}
