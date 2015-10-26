<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use App\User;
use App\UserAlias;
use Kodeine\Acl\Models\Eloquent\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'mobile' => '18616022533',
            'password' => bcrypt('admin')
        ]);

        $user->aliases()->create([
            'user_id' => $user->id,
            'provider' => 'system',
            'alias' => '18616022533',
            'type' => 'username'
        ]);

        $roleAdmin = Role::create([
            'name' => 'Administrator',
            'slug' => 'administrator',
            'description' => 'manage administration privileges'
        ]);

        $roleMember = Role::create([
            'name' => 'Member',
            'slug' => 'member',
            'description' => 'members role'
        ]);

        $user->assignRole($roleAdmin);


    }
}
