<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournamentLiveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournament_live', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->default(null);
            $table->unsignedBigInteger('tournament_categories_id')->nullable()->default(0);
            $table->tinyInteger('status')->nullable()->default(null);
            $table->longText('image')->nullable()->default(null);
            $table->longText('content')->nullable()->default(null);
            $table->longText('url_key')->nullable()->default(null);
            $table->tinyInteger('type')->nullable()->default(null);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tournament_live', function (Blueprint $table) {
            //
        });
    }
}
