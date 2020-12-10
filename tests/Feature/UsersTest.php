<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersTest extends TestCase
{
    use DatabaseMigrations;

    public $username = 'romagod';
    public $email = 'romagod@romagod.ru';
    public $password = 'qwertyq1';

    public function setUp() : void
    {
        parent::setUp();

        $this->seed();
    }

    /**
     * Sign In test.
     *
     * @return void
     */
    /** @test  */
    public function a_user_can_sign_in()
    {
        $response = $this->json('POST', '/api/auth/sign-up', [
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
        ]);
        $content = collect(json_decode($response->getContent()));
        $code = $content['code'];
        $message = $content['message'];
        if ($code !== 200) {
            $this->assertTrue(false, $message);
        }
        $response
                ->assertStatus(200);
    }

    /**
     * Login test.
     *
     * @return void
     */
    /** @test  */
    public function a_user_can_login()
    {
        $this->json('POST', '/api/auth/sign-up', [
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
        ]);

        $response = $this->json('POST', '/api/auth/login', [
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
        ]);
        $content = collect(json_decode($response->getContent()));
        $code = $content['code'];
        $message = $content['message'];
        if ($code !== 200) {
            $this->assertTrue(false, $message);
        }
        $response
            ->assertStatus(200);
    }


    /**
     * User info test.
     *
     * @return void
     */
    /** @test  */
    public function a_user_can_browse_info()
    {
        $this->json('POST', '/api/auth/sign-up', [
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
        ]);

        $response = $this->json('POST', '/api/auth/login', [
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
        ]);
        $content = collect(json_decode($response->getContent()));
        $code = $content['code'];
        $message = $content['message'];
        if ($code !== 200) {
            $this->assertTrue(false, $message);
        }
        $token = $content['data']->token;
        $response = $this->get('/api/user', ['Authorization' => "Bearer $token"]);
        $response->assertStatus(200);
    }
}
