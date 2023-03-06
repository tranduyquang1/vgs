<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmailTemplateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('email_template', function(Blueprint $table)
		{
			$table->smallInteger('id', true);
			$table->string('name')->nullable();
			$table->string('title', 1000)->nullable();
			$table->text('content', 65535)->nullable();
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
		Schema::drop('email_template');
	}

}
