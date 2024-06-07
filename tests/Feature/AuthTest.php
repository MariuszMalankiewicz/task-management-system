<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /***
        Test for store
    ***/

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

    /***
        Test for login
    ***/
    public function test_login_user_sucessfull()
    {
        $user = [
            'name' => 'name',
            'email' => 'test@test.com',
            'password' => 'password'
        ];

        User::create($user);

        $this->postJson(route('users.login', $user))
            ->assertOk()
            ->json([
                'message' => 'successful login',
                'data' => array(
                    'token_type' => 'Bearer'
                    )
                ]);
    }

    public function test_email_and_password_field_is_required_login()
    {
        $user = $this->emptyUser();

        $this->postJson(route('users.login'), $user)
            ->assertUnprocessable()
            ->assertJson([
                array(
                    'email' => array('The email field is required.'),
                    'password' => array('The password field is required.')
                    )
        ]);
    }

    public function test_email_is_not_valid()
    {
        $user = [
            'email' => 'somting wrong',
            'password' => 'somting wrong'
        ];

        $this->postJson(route('users.login'), $user)
            ->assertUnprocessable()
            ->json([
                'email' => 'The email field must be a valid email address.'
            ]);

    }

    public function test_email_or_password_is_not_correct()
    {
        $user = $this->createUser()->toArray();

        $user['email'] = 'test@test.com';
        $user['password'] = 'somting wrong';

        $this->postJson(route('users.login'), $user)
            ->assertNotFound()
            ->json([
                'message' => 'email or password is not correct',
                'data' => null
            ]);
    }

}
