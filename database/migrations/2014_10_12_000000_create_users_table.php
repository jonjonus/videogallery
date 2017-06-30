<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(['name' => 'videos1', 'email' => 'videogallery1@creativa.com.au', 'password' => bcrypt('bapUdu4ra5@e')]);
        DB::table('users')->insert(['name' => 'videos2', 'email' => 'videogallery2@creativa.com.au', 'password' => bcrypt('ga7aNUD_2T?W')]);
        DB::table('users')->insert(['name' => 'videos3', 'email' => 'videogallery3@creativa.com.au', 'password' => bcrypt('5we6UprABe#u')]);
        DB::table('users')->insert(['name' => 'videos4', 'email' => 'videogallery4@creativa.com.au', 'password' => bcrypt('Vav+SpuW3uWr')]);
        DB::table('users')->insert(['name' => 'videos5', 'email' => 'videogallery5@creativa.com.au', 'password' => bcrypt('W+ac5AvaYev&')]);
        DB::table('users')->insert(['name' => 'videos6', 'email' => 'videogallery6@creativa.com.au', 'password' => bcrypt('PEp*8v2tracR')]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
