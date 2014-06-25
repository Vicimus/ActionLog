<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('action_log', function(Blueprint $table)
		{
			//initial struture for testing (simplified)
			//can be expanded on in a future migration
			$table->increments('id');
			$table->string('application', 40)->nullable();
			$table->string('session_id');
			$table->integer('user_id')->nullable()->unsigned();
			$table->string('action_name');
			$table->string('route');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('action_log');
	}

}
