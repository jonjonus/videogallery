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

        DB::table('metatexts')->insert(['name' => 'Drone']);
        DB::table('metatexts')->insert(['name' => 'Screen Capture ']);
        DB::table('metatexts')->insert(['name' => 'Talent']);
        DB::table('metatexts')->insert(['name' => 'Timelapse']);
        DB::table('metatexts')->insert(['name' => '3D']);
        DB::table('metatexts')->insert(['name' => 'Stock']);
        DB::table('metatexts')->insert(['name' => 'Humor / Comic']);
        DB::table('metatexts')->insert(['name' => 'Multicamera']);
        DB::table('metatexts')->insert(['name' => 'Hype Reel']);
        DB::table('metatexts')->insert(['name' => 'Kinetic']);
        DB::table('metatexts')->insert(['name' => 'Sketch - Whiteboard']);
        DB::table('metatexts')->insert(['name' => 'App']);
        DB::table('metatexts')->insert(['name' => 'Case Study']);
        DB::table('metatexts')->insert(['name' => 'Event']);
        DB::table('metatexts')->insert(['name' => 'Blog']);
        DB::table('metatexts')->insert(['name' => 'Update - Report']);
        DB::table('metatexts')->insert(['name' => 'Report']);
        DB::table('metatexts')->insert(['name' => 'Product']);
        DB::table('metatexts')->insert(['name' => 'Chinese']);
        DB::table('metatexts')->insert(['name' => 'UK']);
        DB::table('metatexts')->insert(['name' => 'USA']);
        DB::table('metatexts')->insert(['name' => 'TVC']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metatexts');
    }
}