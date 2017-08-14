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

        DB::table('tagtypes')->insert(['name' => 'Confidentiality']);
        DB::table('tagtypes')->insert(['name' => 'Price']);
        DB::table('tagtypes')->insert(['name' => 'Product']);
        DB::table('tagtypes')->insert(['name' => 'Objective']);
        DB::table('tagtypes')->insert(['name' => 'Industry']);
        DB::table('tagtypes')->insert(['name' => 'Award']);
        DB::table('tagtypes')->insert(['name' => 'Location']);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tagtypes');
    }
}
