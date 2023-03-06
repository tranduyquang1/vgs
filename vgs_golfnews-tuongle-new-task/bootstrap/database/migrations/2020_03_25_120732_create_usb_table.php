<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsbTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('usb', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->nullable();
			$table->string('status')->nullable();
			$table->integer('sort')->nullable();
			$table->float('size', 11)->nullable();
			$table->integer('total')->nullable();
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
		Schema::drop('usb');
	}

}
