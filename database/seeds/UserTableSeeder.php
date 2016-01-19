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

        $userManager = User::create([
            'name' => '用户管理员',
            'mobile' => '13888888888',
            'password' => bcrypt('123456')
        ]);

        $userReserveManager = User::create([
            'name' => '预约管理员',
            'mobile' => '13666666666',
            'password' => bcrypt('123456')
        ]);

        $roleAdmin = Role::create([
            'name' => 'Administrator',
            'slug' => 'administrator',
            'description' => 'manage administration privileges'
        ]);

        $roleRM = Role::create([
            'name' => 'ReserveManager',
            'slug' => 'reserveManager',
            'description' => 'manage reserve'
        ]);

        $roleUM = Role::create([
            'name' => 'UserManager',
            'slug' => 'userManager',
            'description' => 'manage user'
        ]);

        $roleMember = Role::create([
            'name' => 'Member',
            'slug' => 'member',
            'description' => 'members role'
        ]);

        $user->assignRole($roleAdmin);
        $userManager->assignRole($roleUM);
        $userReserveManager->assignRole($roleRM);


    }
}
