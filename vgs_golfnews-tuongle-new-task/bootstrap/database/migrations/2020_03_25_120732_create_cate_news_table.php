<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCateNewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cate_news', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('name');
			$table->string('slug')->nullable();
			$table->integer('_lft')->unsigned()->default(0);
			$table->integer('_rgt')->unsigned()->default(0);
			$table->integer('parent_id')->unsigned()->nullable();
			$table->char('status', 50)->nullable();
			$table->dateTime('created')->nullable();
			$table->string('created_by', 50)->nullable();
			$table->dateTime('modified')->nullable();
			$table->string('modified_by', 50)->nullable();
			$table->string('meta_title')->nullable();
			$table->string('meta_description', 1000)->nullable();
			$table->string('meta_keyword')->nullable();
			$table->index(['_lft','_rgt','parent_id'], 'menu_models__lft__rgt_parent_id_index');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cate_news');
	}

}
