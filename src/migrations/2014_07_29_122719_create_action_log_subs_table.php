<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionLogSubsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('action_log_sub', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('email');
			$table->string('route')->nullable();
			$table->string('keywords')->nullable();
			$table->integer('count')->default(0);
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
		Schema::drop('action_log_sub');
	}

}
