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
        DB::table('tags')->insert(['value' => 'Private',   'tagtype_id' => 1]);
        DB::table('tags')->insert(['value' => 'Face2Face', 'tagtype_id' => 1]);
        DB::table('tags')->insert(['value' => 'Caution',   'tagtype_id' => 1]);
        DB::table('tags')->insert(['value' => 'Public',    'tagtype_id' => 1]);
        //Price
        DB::table('tags')->insert(['value' => '5',  'tagtype_id' => 2]);
        DB::table('tags')->insert(['value' => '10', 'tagtype_id' => 2]);
        DB::table('tags')->insert(['value' => '15', 'tagtype_id' => 2]);
        DB::table('tags')->insert(['value' => '20', 'tagtype_id' => 2]);
        DB::table('tags')->insert(['value' => '50', 'tagtype_id' => 2]);
        DB::table('tags')->insert(['value' => '51', 'tagtype_id' => 2]);
        //Product
        DB::table('tags')->insert(['value' => 'Animations - Simpler',            'tagtype_id' => 3]);
        DB::table('tags')->insert(['value' => 'Animations - Enhanced',           'tagtype_id' => 3]);
        DB::table('tags')->insert(['value' => 'Animations - Advance',            'tagtype_id' => 3]);
        DB::table('tags')->insert(['value' => 'Animations - 3D',                 'tagtype_id' => 3]);
        DB::table('tags')->insert(['value' => 'Dynamic Video',                   'tagtype_id' => 3]);
        DB::table('tags')->insert(['value' => 'Interviews - Advanced',           'tagtype_id' => 3]);
        DB::table('tags')->insert(['value' => 'Interviews - Basic',              'tagtype_id' => 3]);
        DB::table('tags')->insert(['value' => 'Presenter - Advanced',            'tagtype_id' => 3]);
        DB::table('tags')->insert(['value' => 'Presenter - Basic',               'tagtype_id' => 3]);
        DB::table('tags')->insert(['value' => 'Promo (Live action other)',       'tagtype_id' => 3]);
        DB::table('tags')->insert(['value' => 'Role Play - Advanced',            'tagtype_id' => 3]);
        DB::table('tags')->insert(['value' => 'Role Play - Basic',               'tagtype_id' => 3]);
        DB::table('tags')->insert(['value' => 'Screen Cast - Advanced',          'tagtype_id' => 3]);
        DB::table('tags')->insert(['value' => 'Screen Cast - Basic',             'tagtype_id' => 3]);
        DB::table('tags')->insert(['value' => 'Presentation - with power point', 'tagtype_id' => 3]);
        //Objective
        DB::table('tags')->insert(['value' => 'Training',       'tagtype_id' => 4]);
        DB::table('tags')->insert(['value' => 'Marketing',      'tagtype_id' => 4]);
        DB::table('tags')->insert(['value' => 'Internal Comms', 'tagtype_id' => 4]);
        //Industry
        DB::table('tags')->insert(['value' => 'Education',     'tagtype_id' => 5]);
        DB::table('tags')->insert(['value' => 'Financial',     'tagtype_id' => 5]);
        DB::table('tags')->insert(['value' => 'Government',    'tagtype_id' => 5]);
        DB::table('tags')->insert(['value' => 'Health',        'tagtype_id' => 5]);
        DB::table('tags')->insert(['value' => 'Automotive',    'tagtype_id' => 5]);
        DB::table('tags')->insert(['value' => 'Lifestyle',     'tagtype_id' => 5]);
        DB::table('tags')->insert(['value' => 'HR',            'tagtype_id' => 5]);
        DB::table('tags')->insert(['value' => 'Manufacturing', 'tagtype_id' => 5]);
        DB::table('tags')->insert(['value' => 'IT',            'tagtype_id' => 5]);
        DB::table('tags')->insert(['value' => 'Marketing',     'tagtype_id' => 5]);
        DB::table('tags')->insert(['value' => 'NFP',           'tagtype_id' => 5]);
        DB::table('tags')->insert(['value' => 'P-Services',    'tagtype_id' => 5]);
        DB::table('tags')->insert(['value' => 'Real Estate',   'tagtype_id' => 5]);
        DB::table('tags')->insert(['value' => 'Retail',        'tagtype_id' => 5]);
        DB::table('tags')->insert(['value' => 'OH&S',          'tagtype_id' => 5]);
        DB::table('tags')->insert(['value' => 'Utilities',     'tagtype_id' => 5]);
        DB::table('tags')->insert(['value' => 'Trades',        'tagtype_id' => 5]);
        DB::table('tags')->insert(['value' => 'Logistics',     'tagtype_id' => 5]);
        DB::table('tags')->insert(['value' => 'Agency',        'tagtype_id' => 5]);
        DB::table('tags')->insert(['value' => 'Other',         'tagtype_id' => 5]);
        //Award
        DB::table('tags')->insert(['value' => 'AVPA',    'tagtype_id' => 6]);
        DB::table('tags')->insert(['value' => 'AIPP',    'tagtype_id' => 6]);
        DB::table('tags')->insert(['value' => 'HORIZON', 'tagtype_id' => 6]);
        DB::table('tags')->insert(['value' => 'MUSE',    'tagtype_id' => 6]);
        //Location
        DB::table('tags')->insert(['value' => 'Studio',      'tagtype_id' => 7]);
        DB::table('tags')->insert(['value' => 'Client Site', 'tagtype_id' => 7]);
        DB::table('tags')->insert(['value' => 'Location',    'tagtype_id' => 7]);
        DB::table('tags')->insert(['value' => 'Outdoors',    'tagtype_id' => 7]);
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
