<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = Role::where('name', 'user')->first();
        $role_admin= Role::where('name', 'admin')->first();

        $user = new User();
        $user->name = 'videos1';
        $user->email = 'videogallery1@creativa.com.au';
        $user->password = bcrypt('bapUdu4ra5@e');
        $user->save();
        $user->roles()->attach($role_user);

        $user = new User();
        $user->name = 'videos2';
        $user->email = 'videogallery2@creativa.com.au';
        $user->password = bcrypt('ga7aNUD_2T?W');
        $user->save();
        $user->roles()->attach($role_user);

        $user = new User();
        $user->name = 'videos3';
        $user->email = 'videogallery3@creativa.com.au';
        $user->password = bcrypt('5we6UprABe#u');
        $user->save();
        $user->roles()->attach($role_user);

        $user = new User();
        $user->name = 'videos4';
        $user->email = 'videogallery4@creativa.com.au';
        $user->password = bcrypt('Vav+SpuW3uWr');
        $user->save();
        $user->roles()->attach($role_user);

        $user = new User();
        $user->name = 'videos5';
        $user->email = 'videogallery5@creativa.com.au';
        $user->password = bcrypt('W+ac5AvaYev&');
        $user->save();
        $user->roles()->attach($role_user);

        $user = new User();
        $user->name = 'videos6';
        $user->email = 'videogallery6@creativa.com.au';
        $user->password = bcrypt('PEp*8v2tracR');
        $user->save();
        $user->roles()->attach($role_user);

        //ADMINs
        $admin = new User();
        $admin->name = 'Daniela Donnenfeld';
        $admin->email = 'danielad@creativa.com.au';
        $admin->password = bcrypt('5k$UcWqrsy3x');
        $admin->save();
        $admin->roles()->attach($role_admin);

        $admin = new User();
        $admin->name = 'Damian Blumenkranc';
        $admin->email = 'damian@creativa.com.au';
        $admin->password = bcrypt('T8WOAb@s^Jw1');
        $admin->save();
        $admin->roles()->attach($role_admin);



    }
}
