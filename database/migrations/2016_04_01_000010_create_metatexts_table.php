<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetatextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metatexts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->timestamps();
        });

        DB::table('users')->insert(['name' => 'Drone']);
        DB::table('users')->insert(['name' => 'Screen Capture ']);
        DB::table('users')->insert(['name' => 'Talent']);
        DB::table('users')->insert(['name' => 'Timelapse']);
        DB::table('users')->insert(['name' => '3D']);
        DB::table('users')->insert(['name' => 'Stock']);
        DB::table('users')->insert(['name' => 'Humor / Comic']);
        DB::table('users')->insert(['name' => 'Multicamera']);
        DB::table('users')->insert(['name' => 'Hype Reel']);
        DB::table('users')->insert(['name' => 'Kinetic']);
        DB::table('users')->insert(['name' => 'Sketch - Whiteboard']);
        DB::table('users')->insert(['name' => 'App']);
        DB::table('users')->insert(['name' => 'Case Study']);
        DB::table('users')->insert(['name' => 'Event']);
        DB::table('users')->insert(['name' => 'Blog']);
        DB::table('users')->insert(['name' => 'Update - Report']);
        DB::table('users')->insert(['name' => 'Report']);
        DB::table('users')->insert(['name' => 'Product']);
        DB::table('users')->insert(['name' => 'Chinese']);
        DB::table('users')->insert(['name' => 'UK']);
        DB::table('users')->insert(['name' => 'USA']);
        DB::table('users')->insert(['name' => 'TVC']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('metatexts');
    }
}