<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('username');
			$table->string('email')->nullable();
			$table->string('fullname')->nullable();
			$table->string('password')->nullable();
			$table->string('avatar')->nullable();
			$table->string('level', 10)->nullable();
			$table->dateTime('created')->nullable();
			$table->string('created_by', 45)->nullable();
			$table->dateTime('modified')->nullable();
			$table->string('modified_by', 45)->nullable();
			$table->string('status', 10)->nullable()->default('0');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user');
	}

}
