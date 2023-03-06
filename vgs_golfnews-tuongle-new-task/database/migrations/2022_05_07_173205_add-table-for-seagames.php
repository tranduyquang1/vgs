<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTableForSeagames extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('banners_seagames', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->default(null);
            $table->longText('thumb')->nullable()->default(null);
            $table->longText('url')->nullable()->default(null);
            $table->tinyInteger('type')->nullable()->default(null);
            $table->tinyInteger('status')->nullable()->default(null);

        });
        Schema::create('lives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->default(null);
            $table->longText('image')->nullable()->default(null);
            $table->longText('content')->nullable()->default(null);
            $table->longText('url_key')->nullable()->default(null);
            $table->tinyInteger('type')->nullable()->default(null);

            $table->tinyInteger('status')->nullable()->default(null);

        });
        Schema::table('posts', function (Blueprint $table) {
            $table->tinyInteger('language')->nullable()->default(0);
        });
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banners_seagames');
        Schema::dropIfExists('lives');
        
    }
}
