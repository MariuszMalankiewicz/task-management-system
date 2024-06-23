<?php

namespace Tests\Feature\Authentication;

use Tests\TestCase;
use App\Models\user;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_user_sucessfull()
    {
        $user = [
            'name' => 'name',
            'email' => 'test@test.com',
            'password' => 'password'
        ];

        user::create($user);

        $this->postJson(route('login', $user))
            ->assertOk()
            ->json([
                'message' => 'successful login',
                'data' => array(
                    'token_type' => 'Bearer'
                    )
                ]);
    }

    public function test_login_email_and_password_fields_is_required()
    {
        $user = $this->emptyuser();

        $this->postJson(route('login'), $user)
            ->assertUnprocessable()
            ->assertJson([
                array(
                    'email' => array('The email field is required.'),
                    'password' => array('The password field is required.')
                    )
        ]);
    }

    public function test_login_email_field_is_not_valid()
    {
        $user = [
            'email' => 'somting wrong',
            'password' => 'somting wrong'
        ];

        $this->postJson(route('login'), $user)
            ->assertUnprocessable()
            ->json([
                'email' => 'The email field must be a valid email address.'
            ]);

    }

    public function test_login_email_or_password_fields_is_not_correct()
    {
        $user = $this->user()->create()->makeVisible('password')->toArray();

        $user['email'] = 'test@test.com';
        $user['password'] = 'somting wrong';

        $this->postJson(route('login'), $user)
            ->assertNotFound()
            ->json([
                'message' => 'email or password is not correct',
                'data' => null
            ]);
    }
}
