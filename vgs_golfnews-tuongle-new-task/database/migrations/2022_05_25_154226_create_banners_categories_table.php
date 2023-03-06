<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable()->default(null);
            $table->longText('thumb')->nullable()->default(null);
            $table->longText('url')->nullable()->default(null);
            $table->integer('category_id')->nullable()->default(null);
            $table->tinyInteger('type')->nullable()->default(null);
            $table->tinyInteger('position')->nullable()->default(null);

            $table->tinyInteger('is_mobile')->default(0);

            $table->tinyInteger('status')->nullable()->default(0);
            $table->dateTime('last_viewed_at')->nullable();
            $table->integer('viewed_count')->default(0);
            $table->integer('clicked_count')->default(0);
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
        Schema::dropIfExists('banners_categories');
    }
}
