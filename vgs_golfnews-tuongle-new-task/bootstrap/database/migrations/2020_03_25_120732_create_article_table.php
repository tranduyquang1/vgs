<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('post', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('category_id')->nullable();
			$table->string('name');
			$table->string('slug');
			$table->text('description', 65535)->nullable();
			$table->text('content', 65535)->nullable();
			$table->string('status', 225)->nullable();
			$table->string('thumb')->nullable();
			$table->string('banner')->nullable();
			$table->string('type')->nullable();
			$table->dateTime('created')->nullable();
			$table->string('created_by')->nullable();
			$table->dateTime('modified')->nullable();
			$table->string('modified_by')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('post');
	}

}
