<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;


class AuthTest extends TestCase
{
    use RefreshDatabase;

    private function ddResponse($response)
    {
        if ($response->exception == null) {
            $contents = json_decode(($response->baseResponse->getContent()));

            if ($contents == null) {
                dd(null);
            }

            dd($contents);
        } else {
            dd($response->exception);
        }
    }

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_register()
    {
        $data = [
            'name' => 'aaa',
            'email' => 'aaa@aaa.aaa',
            'password' => 'aaa',
            'password_confirm' => 'aaa',
        ];
        $response = $this->post('/api/register', $data);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'created_at',
            'updated_at',
        ]);
    }

    public function test_login()
    {
        User::create([
            'name' => 'aaa',
            'email' => 'aaa@aaa.aaa',
            'password' => Hash::make('aaa'),
        ]);

        $data = [
            'email' => 'aaa@aaa.aaa',
            'password' => 'aaa',
        ];
        $response = $this->post('/api/login', $data);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'jwt',
        ]);
        $this->assertAuthenticated();
    }
}
