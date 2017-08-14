<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaylistVideoTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('playlist_video', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('playlist_id')->unsigned()->index();
			$table->foreign('playlist_id')
			      ->references('id')
			      ->on('playlists')
			      ->onDelete('cascade')
			      ->onUpdate('restrict');

			$table->integer('video_id')->unsigned()->index();
			$table->foreign('video_id')
			      ->references('id')
			      ->on('videos')
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
		Schema::dropIfExists('playlist_video');
	}
}
