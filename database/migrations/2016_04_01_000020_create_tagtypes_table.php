<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagtypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagtypes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->timestamps();
        });

        DB::table('users')->insert(['name' => 'Confidentiality']);
        DB::table('users')->insert(['name' => 'Price']);
        DB::table('users')->insert(['name' => 'Product']);
        DB::table('users')->insert(['name' => 'Objective']);
        DB::table('users')->insert(['name' => 'Industry']);
        DB::table('users')->insert(['name' => 'Award']);
        DB::table('users')->insert(['name' => 'Location']);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tagtypes');
    }
}
