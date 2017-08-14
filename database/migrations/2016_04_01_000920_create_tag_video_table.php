<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagVideoTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tag_video', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('tag_id')->unsigned()->index();
			$table->foreign('tag_id')
			      ->references('id')
			      ->on('tags')
			      ->onDelete('restrict')
			      ->onUpdate('restrict');

			$table->integer('video_id')->unsigned()->index();
			$table->foreign('video_id')
			      ->references('id')
			      ->on('videos')
			      ->onDelete('cascade')
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
		Schema::dropIfExists('tag_video');
	}
}
