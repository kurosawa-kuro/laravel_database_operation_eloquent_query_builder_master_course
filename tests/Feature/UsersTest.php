<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;


class UsersTest extends TestCase
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

    protected function setUp(): void // ※ Voidが必要
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
    public function test_index()
    {
        User::create([
            'name' => 'sample user2',
            'email' => 'sample2@sankosc.co.jp',
            'password' => Hash::make('sample123'),
        ]);

        $response = $this->get('/api/users', [
            'Authorization' => 'Bearer ' . $this->accessToken
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(
            [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'role',
                    'avatar',
                ],
            ]
        );
        $response->assertJsonCount(2);
    }

    public function test_store()
    {
        $data = [
            'name' => 'aaa',
            'email' => 'aaa@aaa.aaa',
            'password' => 'aaa',
            'password_confirm' => 'aaa',
            'role' => 'user',
            'avatar' => 'https://i.pravatar.cc/300',
        ];

        $response = $this->post('/api/users', $data, [
            'Authorization' => 'Bearer ' . $this->accessToken
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure(
            [
                'id',
                'name',
                'email',
                'role',
                'avatar',
            ]
        );
    }

    public function test_show()
    {
        $response = $this->get('/api/users/1', [
            'Authorization' => 'Bearer ' . $this->accessToken
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(
            [
                'id',
                'name',
                'email',
                'role',
                'avatar',
            ]
        );
    }

    public function test_update()
    {
        $data = [
            'name' => 'updated aaa',
            'email' => 'aaa@aaa.aaa',
            'password' => 'aaa',
            'password_confirm' => 'aaa',
            'role' => 'user',
            'avatar' => 'https://i.pravatar.cc/300',
        ];

        $response = $this->put('/api/users/1',$data, [
            'Authorization' => 'Bearer ' . $this->accessToken
        ]);

        $response->assertStatus(Response::HTTP_ACCEPTED);
        $response->assertJsonStructure(
            [
                'id',
                'name',
                'email',
                'role',
                'avatar',
            ]
        );

        $this->assertEquals($data['name'], json_decode($response->getContent())->name);
//        $this->assertEquals($data['name'], json_decode($response->getOriginalContent())->name);
    }

    public function test_destroy()
    {
        $response = $this->delete('/api/users/1', [
            'Authorization' => 'Bearer ' . $this->accessToken
        ]);

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertEquals('', json_decode($response->getOriginalContent()));
    }
}
