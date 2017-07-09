<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string('value');
            $table->integer('tagtype_id')->unsigned();

            $table->timestamps();

            $table->foreign('tagtype_id')
                ->references('id')
                ->on('tagtypes')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });

        //Confidentiality
        DB::table('users')->insert(['value' => 'Private',   'tagtype_id' => 1]);
        DB::table('users')->insert(['value' => 'Face2Face', 'tagtype_id' => 1]);
        DB::table('users')->insert(['value' => 'Caution',   'tagtype_id' => 1]);
        DB::table('users')->insert(['value' => 'Public',    'tagtype_id' => 1]);
        //Price
        DB::table('users')->insert(['value' => '5',  'tagtype_id' => 2]);
        DB::table('users')->insert(['value' => '10', 'tagtype_id' => 2]);
        DB::table('users')->insert(['value' => '15', 'tagtype_id' => 2]);
        DB::table('users')->insert(['value' => '20', 'tagtype_id' => 2]);
        DB::table('users')->insert(['value' => '50', 'tagtype_id' => 2]);
        DB::table('users')->insert(['value' => '51', 'tagtype_id' => 2]);
        //Product
        DB::table('users')->insert(['value' => 'Animations - Simpler',            'tagtype_id' => 3]);
        DB::table('users')->insert(['value' => 'Animations - Enhanced',           'tagtype_id' => 3]);
        DB::table('users')->insert(['value' => 'Animations - Advance',            'tagtype_id' => 3]);
        DB::table('users')->insert(['value' => 'Animations - 3D',                 'tagtype_id' => 3]);
        DB::table('users')->insert(['value' => 'Dynamic Video',                   'tagtype_id' => 3]);
        DB::table('users')->insert(['value' => 'Interviews - Advanced',           'tagtype_id' => 3]);
        DB::table('users')->insert(['value' => 'Interviews - Basic',              'tagtype_id' => 3]);
        DB::table('users')->insert(['value' => 'Presenter - Advanced',            'tagtype_id' => 3]);
        DB::table('users')->insert(['value' => 'Presenter - Basic',               'tagtype_id' => 3]);
        DB::table('users')->insert(['value' => 'Promo (Live action other)',       'tagtype_id' => 3]);
        DB::table('users')->insert(['value' => 'Role Play - Advanced',            'tagtype_id' => 3]);
        DB::table('users')->insert(['value' => 'Role Play - Basic',               'tagtype_id' => 3]);
        DB::table('users')->insert(['value' => 'Screen Cast - Advanced',          'tagtype_id' => 3]);
        DB::table('users')->insert(['value' => 'Screen Cast - Basic',             'tagtype_id' => 3]);
        DB::table('users')->insert(['value' => 'Presentation - with power point', 'tagtype_id' => 3]);
        //Objective
        DB::table('users')->insert(['value' => 'Training',       'tagtype_id' => 4]);
        DB::table('users')->insert(['value' => 'Marketing',      'tagtype_id' => 4]);
        DB::table('users')->insert(['value' => 'Internal Comms', 'tagtype_id' => 4]);
        //Industry
        DB::table('users')->insert(['value' => 'Education',     'tagtype_id' => 5]);
        DB::table('users')->insert(['value' => 'Financial',     'tagtype_id' => 5]);
        DB::table('users')->insert(['value' => 'Government',    'tagtype_id' => 5]);
        DB::table('users')->insert(['value' => 'Health',        'tagtype_id' => 5]);
        DB::table('users')->insert(['value' => 'Automotive',    'tagtype_id' => 5]);
        DB::table('users')->insert(['value' => 'Lifestyle',     'tagtype_id' => 5]);
        DB::table('users')->insert(['value' => 'HR',            'tagtype_id' => 5]);
        DB::table('users')->insert(['value' => 'Manufacturing', 'tagtype_id' => 5]);
        DB::table('users')->insert(['value' => 'IT',            'tagtype_id' => 5]);
        DB::table('users')->insert(['value' => 'Marketing',     'tagtype_id' => 5]);
        DB::table('users')->insert(['value' => 'NFP',           'tagtype_id' => 5]);
        DB::table('users')->insert(['value' => 'P-Services',    'tagtype_id' => 5]);
        DB::table('users')->insert(['value' => 'Real Estate',   'tagtype_id' => 5]);
        DB::table('users')->insert(['value' => 'Retail',        'tagtype_id' => 5]);
        DB::table('users')->insert(['value' => 'OH&S',          'tagtype_id' => 5]);
        DB::table('users')->insert(['value' => 'Utilities',     'tagtype_id' => 5]);
        DB::table('users')->insert(['value' => 'Trades',        'tagtype_id' => 5]);
        DB::table('users')->insert(['value' => 'Logistics',     'tagtype_id' => 5]);
        DB::table('users')->insert(['value' => 'Agency',        'tagtype_id' => 5]);
        DB::table('users')->insert(['value' => 'Other',         'tagtype_id' => 5]);
        //Award
        DB::table('users')->insert(['value' => 'AVPA',    'tagtype_id' => 6]);
        DB::table('users')->insert(['value' => 'AIPP',    'tagtype_id' => 6]);
        DB::table('users')->insert(['value' => 'HORIZON', 'tagtype_id' => 6]);
        DB::table('users')->insert(['value' => 'MUSE',    'tagtype_id' => 6]);
        //Location
        DB::table('users')->insert(['value' => 'Studio',      'tagtype_id' => 7]);
        DB::table('users')->insert(['value' => 'Client Site', 'tagtype_id' => 7]);
        DB::table('users')->insert(['value' => 'Location',    'tagtype_id' => 7]);
        DB::table('users')->insert(['value' => 'Outdoors',    'tagtype_id' => 7]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tags');
    }
}
