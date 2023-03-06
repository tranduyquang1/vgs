<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 500);
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->string('format')->default('post');
            $table->text('thumbnail');
            $table->string('status');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->tinyInteger('is_hot_news')->default(0);
            $table->tinyInteger('is_on_slider')->default(0);
            $table->timestamps();
            $table->dateTime('published_at')->nullable();
            $table->dateTime('published_at_display')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('published_by')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->text('youtube_url', '500')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
