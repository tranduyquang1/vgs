<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSliderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('slider', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name');
			$table->text('description', 65535)->nullable();
			$table->string('link', 200)->nullable();
			$table->text('thumb', 65535)->nullable();
			$table->dateTime('created')->nullable();
			$table->string('created_by')->nullable();
			$table->dateTime('modified')->nullable();
			$table->string('modified_by')->nullable();
			$table->text('status', 65535)->nullable();
			$table->integer('sort')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('slider');
	}

}
