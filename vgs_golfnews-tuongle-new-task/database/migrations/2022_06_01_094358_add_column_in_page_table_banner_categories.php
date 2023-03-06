<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInPageTableBannerCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banners_categories', function (Blueprint $table) {
            $table->tinyInteger('is_home')->after('is_mobile')->nullable()->default(0);
            $table->tinyInteger('is_category')->after('is_mobile')->nullable()->default(0);
            $table->tinyInteger('is_post')->after('is_mobile')->nullable()->default(0);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('banners_categories', function (Blueprint $table) {
            //
        });
    }
}
