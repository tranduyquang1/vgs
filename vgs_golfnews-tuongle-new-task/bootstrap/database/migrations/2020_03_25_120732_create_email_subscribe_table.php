<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmailSubscribeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('email_subscribe', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('email')->nullable();
			$table->string('status')->nullable();
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
		Schema::drop('email_subscribe');
	}

}
