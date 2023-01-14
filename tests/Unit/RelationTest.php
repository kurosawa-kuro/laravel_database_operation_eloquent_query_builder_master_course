<?php

namespace Tests\Unit;

use App\Models\Company;
use App\Models\Group;
use App\Models\User;
use App\Models\UserProfile;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RelationTest extends TestCase
{
    use RefreshDatabase;

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

        $userProfile = UserProfile::create([
            'user_id' => 1,
            'age' => 20
        ]);
//        dd($userProfile ->toArray());
//        dd($user->profile()->get() ->toArray());
        $userWithUserProfile = User::with('profile')->get();
//        dd($userWithUserProfile ->toArray());


        $otherUser = User::find(2);
        $otherUser->profile()->create(['age' => 30]);
        $otherUser = User::with('profile')->get();
        dd($otherUser->toArray());
        $this->assertTrue(true
        );
    }

    public function test_one_to_many()
    {
        User::factory(2)->create();
        $users = User::all();
//        dd($users);
        Company::create(['name' => 'abc']);
        Company::create(['name' => 'abc2']);
        $company = Company::with('users')->where(['id' => 1])->get();
//        dd($company->toArray());

        $user = User::find(2);
        $user->update(['company_id' => 2]);

        $otherUser = User::with('company')->where(['id' => 1])->get();
        dd($otherUser->toArray());
        $this->assertTrue(true);
    }

    public function test_many_to_many()
    {
        User::factory()->create();;
        Group::create(['name' => 'g1']);
        Group::create(['name' => 'g2']);
//        $user = User::find(1);
//        dd($user ->toArray());
//        User::find(1)->groups()->sync([1,2]);
        User::find(1)->groups()->attach(2);

//        $user = User::find(1)->groups()->get();
//        dd($user->toArray());

        $user = User::with('groups')->where(['id'=>1])->get();
        dd($user->toArray());

        $this->assertTrue(true);
    }
}
