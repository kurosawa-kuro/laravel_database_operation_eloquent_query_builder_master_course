<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;


class ProtectedTest extends TestCase
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

    protected function setUp(): Void // ※ Voidが必要
    {
        parent::setUp();

        User::create([
            'name' => 'sample user',
            'email' => 'sample@sankosc.co.jp',
            'password' => Hash::make('sample123'),
        ]);
        $response = $this->post('/api/login', [
            'email' => 'sample@sankosc.co.jp',
            'password' => 'sample123'
        ]);

        $response->assertOk();

        try {
//            $this->accessToken = $response->decodeResponseJson('jwt')->json('jwt');
            $this->accessToken = $response->getCookie('jwt')->getValue();
        } catch (\Throwable $e) {
            echo $e;
        }
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_protected_hello_list()
    {
        $response = $this->get('/api/protected_hello_list', [
            'Authorization' => 'Bearer '.$this->accessToken
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'first',
            'second',
            'third',
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

    public function test_user()
    {
        $response = $this->get('/api/user');
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'id',
            'name',
            'email',
            'email_verified_at',
            'role',
            'avatar',
            'created_at',
            'updated_at',
        ]);
        $this->assertAuthenticated();
    }
}
