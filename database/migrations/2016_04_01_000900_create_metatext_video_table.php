<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetatextVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metatext_video', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('video_id')->unsigned()->index();
            $table->foreign('video_id')
                ->references('id')
                ->on('videos')
                ->onDelete('cascade')
                ->onUpdate('restrict');
            
            $table->integer('metatext_id')->unsigned()->index();
            $table->foreign('metatext_id')
                ->references('id')
                ->on('metatexts')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('metatext_video');
    }
}
