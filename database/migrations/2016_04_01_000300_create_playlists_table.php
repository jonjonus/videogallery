<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaylistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playlists', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('url');
	        $table->string('pattern');
	        $table->string('title')->unique();
	        $table->longText('description');
	        $table->string('password');

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
//	    Schema::table('playlist_video', function (Blueprint $table) {
//		    $table->dropForeign('playlist_video_playlist_id_foreign');
//		    $table->dropColumn('playlist_id');
//	    });
	    DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::drop('playlists');
	    DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
