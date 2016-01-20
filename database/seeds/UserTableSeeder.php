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
            'password' => bcrypt('123456')
        ]);

        $assistantManager = User::create([
            'name' => 'OPAdmin',
            'mobile' => '13888888888',
            'password' => bcrypt('123456')
        ]);


        $roleAdmin = Role::create([
            'name' => 'Administrator',
            'slug' => 'administrator',
            'description' => 'manage administration privileges'
        ]);

        $roleAssistant = Role::create([
            'name' => 'Assistant',
            'slug' => 'assistant',
            'description' => 'assistant'
        ]);

        $roleMember = Role::create([
            'name' => 'Member',
            'slug' => 'member',
            'description' => 'members role'
        ]);

        $user->assignRole($roleAdmin);
        $assistantManager->assignRole($roleAssistant);


    }
}
