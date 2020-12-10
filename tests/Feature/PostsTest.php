<?php

namespace Tests\Feature;

use App\Eloquent\Posts;
use App\Http\Resources\PostResource;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostsTest extends TestCase
{
    use DatabaseMigrations;

    public $username = 'romagod';
    public $email = 'romagod@romagod.ru';
    public $password = 'qwertyq1';

    /**
     * Setting up method
     *
     * @return void
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->seed();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test  */
    public function get_all_posts()
    {
        $count = \DB::table('posts')->count();

        $response = $this->json('GET','/api/post/all');
        $content = collect(json_decode($response->getContent()));
        $code = $content['code'];
        $message = $content['message'];
        if ($code !== 200) {
            $this->assertTrue(false, $message);
        }
        $total = $content['total'];
        if ($count !== $total) {
            $this->assertTrue(false, '$count and $total was different');
        }
        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test  */
    public function create_new_post()
    {
        $this->json('POST', '/api/auth/sign-up', [
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
        ]);

        $response = $this->json('POST', '/api/auth/login', [
            'username' => 'Admin',
            'email' => env('ADMIN_EMAIL', 'admin@romagod.ru'),
            'password' => env('ADMIN_PASS', '123456'),
        ]);
        $content = collect(json_decode($response->getContent()));
        $code = $content['code'];
        $message = $content['message'];
        if ($code !== 200) {
            $this->assertTrue(false, $message);
        }
        $token = $content['data']->token;

        $response = $this->json('POST','/api/post/new', ["title" => "TEST", "description" => "TEST"]);
        if ($response->getStatusCode() !== 401 && $response->getStatusCode() !== 403) {
            $this->assertTrue(false, "middleware doesn't work");
        }
        $response = $this->json(
            'POST',
            '/api/post/new',
            ["title" => "TEST", "description" => "TEST", "tags" => ['testTag1', 'testTag2']],
            ['Authorization' => "Bearer $token"]
        );

        $content = collect(json_decode($response->getContent()));
        $code = $content['code'];
        $message = $content['message'];
        if ($code !== 200) {
            $this->assertTrue(false, $message);
        }
        $response->assertStatus(200);
    }
}
