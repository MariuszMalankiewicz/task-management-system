<?php

namespace Tests\Feature\Authentication;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_user_successful(): void
    {
        $user = $this->user()->make()->makeVisible('password')->toArray();

        $this->postJson(route('registration'), $user)
            ->assertCreated();

        $this->assertDatabaseHas('users', [
            'name' => $user['name'],
            'email' => $user['email'],
        ]);
    }

    public function test_store_user_fields_is_required()
    {
        $user = $this->emptyuser();

        $this->postJson(route('registration'), $user)
            ->assertUnprocessable()
            ->assertJson([
                array(
                    'name' => array('The name field is required.'),
                    'email' => array('The email field is required.'),
                    'password' => array('The password field is required.')
                    )
        ]);
    }

    public function test_store_user_name_and_email_fields_is_unique()
    {
        $user = $this->user()->create()->makeVisible('password')->toArray();

        $this->postJson(route('registration'), $user)
            ->assertUnprocessable()
            ->assertJson([
                array(
                    'name' => array('The name has already been taken.'),
                    'email' => array('The email has already been taken.')
                ),
            ]);
    }
}
