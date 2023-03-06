<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSiteBackgroundColorTableTournamentCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tournament_categories', function (Blueprint $table) {
            $table->string('site_background_color')->after('menu_background_color')->nullable()->default(null);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tournament_categories', function (Blueprint $table) {
            //
        });
    }
}
