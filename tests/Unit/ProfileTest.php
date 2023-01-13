<?php

namespace Tests\Unit;

use App\Models\Profile;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_profile_create()
    {
        $userData = [
            'name' => 'aaa',
            'email' => 'aaa@aaa.aaa',
            'password' => 'aaa',
            'password_confirm' => 'aaa',
            'role' => 'user',
            'avatar' => 'https://i.pravatar.cc/300',
        ];

        $user = User::create($userData);
//        dd($user);

        $profileData = [
            'user_id' => $user->id,
            'address' => 'aaa',
            'phone' => '01231112222',
            'mobile_phone' => '01231112222',
            'bio' => 'aaa',
            'memo' => 'https://i.pravatar.cc/300',
        ];


        $profile = Profile::create($profileData);
//        dd($profile);
        dd($user->profile()->get()->toArray());

        $this->assertEquals(1, $user->count());
    }
}
