<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTournamentCategoriesIdTableLive extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lives', function (Blueprint $table) {
            $table->unsignedBigInteger('tournament_categories_id')->after('name')->nullable()->default(0);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lives', function (Blueprint $table) {
            //
        });
    }
}
