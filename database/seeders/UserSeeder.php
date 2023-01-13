<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'aaa',
            'email' => 'aaa@aaa.aaa',
            'password' => Hash::make('aaa'),
        ]);

        User::factory()->create([
            'name' => 'bbb',
            'email' => 'bbb@bbb.bbb',
            'password' => Hash::make('bbb'),
        ]);

        User::factory()->create([
            'name' => 'ccc',
            'email' => 'ccc@ccc.ccc',
            'password' => Hash::make('ccc'),
        ]);

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.admin',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);

        User::factory(20)->create();
    }
}
