<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTournamentCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tournament_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_home')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->integer('banner_category_id')->nullable()->default(0);

            $table->longText('logo_web_icon')->nullable()->default(null);
            $table->longText('logo_seo')->nullable()->default(null);
            $table->longText('logo_menu')->nullable()->default(null);
            $table->longText('logo_home')->nullable()->default(null);

            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();


            
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
            
        });
    }
}
