<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('settings', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('key_value', 50)->default('0');
			$table->text('value')->nullable();
			$table->string('status', 50)->nullable();
			$table->dateTime('created')->nullable();
			$table->string('created_by', 50)->nullable();
			$table->dateTime('modified')->nullable();
			$table->string('modified_by', 50)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('settings');
	}

}
