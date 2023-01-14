<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\UserProfile;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RelationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_one_to_one()
    {
        User::factory(5)->create();
        $users = User::all();
//        dd($users ->toArray());
        $user = User::find(1);

        $userProfile =  UserProfile::create([
            'user_id'=>1,
            'age'=>20
        ]);
//        dd($userProfile ->toArray());
//        dd($user->profile()->get() ->toArray());
        $userWithUserProfile = User::with('profile')->get();
//        dd($userWithUserProfile ->toArray());


        $otherUser = User::find(2);
        $otherUser->profile()->create(['age'=>30]);
        $otherUser = User::with('profile')->get();
        dd($otherUser ->toArray());
        $this->assertTrue(true
        );
    }
}
