<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('thumbnail');
            $table->string('thumbnail_sm');
            $table->string('thumbnail_hq');
            $table->string('title');
            $table->string('name');
            $table->text('description');
            $table->dateTime('produced_at');
            $table->string('url');
            $table->integer('count_reposts')->unsigned();
            $table->integer('count_watch')->unsigned();
            $table->integer('count_likes')->unsigned();
            $table->boolean('ignore');
            $table->boolean('new');
            $table->string('cloud_id');
            $table->integer('service_id')->unsigned()->nullable();
            $table->integer('client_id')->unsigned()->nullable();
            $table->integer('duration')->unsigned()->nullable();
            $table->longText('embed');

            $table->timestamps();

            $table->softDeletes();

            $table->foreign('client_id')
                ->references('id')
                ->on('clients')
                ->onDelete('restrict')
                ->onUpdate('restrict');


            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->unique(array('service_id', 'cloud_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('videos');
    }
}
