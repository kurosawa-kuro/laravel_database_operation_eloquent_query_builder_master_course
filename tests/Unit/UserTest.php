<?php

namespace Tests\Unit;

use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_create()
    {
        $data = [
            'name' => 'aaa',
            'email' => 'aaa@aaa.aaa',
            'password' => 'aaa',
            'password_confirm' => 'aaa',
            'role' => 'user',
            'avatar' => 'https://i.pravatar.cc/300',
        ];

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'avatar' => $data['avatar'],
            'password' => $data['password'],
        ]);

        $this->assertEquals(1,$user->count());
    }



    /**
     * A basic test example.
     *
     * @return void
     * @throws Exception
     */
    public function test_user_method()
    {
        $inputData = [
            'name' => 'aaa test',
            'email' => 'aaa@aaa.aaa',
            'password' => 'aaa',
            'password_confirm' => 'aaa',
            'role' => 'user',
            'avatar' => 'https://i.pravatar.cc/300',
        ];

        list($data, $error) = User::register($inputData);

        if($error){
            dd($error);
        }

        unset($data['id']);
        unset($data['updated_at']);
        unset($data['created_at']);
//        dd($data->toArray());


        $users = User::get();
//        dd($users->toJson());
        unset($inputData['password']);
        unset($inputData['password_confirm']);
        $this->assertEquals($inputData, $data->toArray());
        $this->assertEquals(1,$users->count());
    }
}
