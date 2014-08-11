<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionPageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('action_page', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('application');
			$table->string('category')->nullable();
			$table->string('session_id');
			$table->integer('user_id')->nullable();
			$table->string('route');
			$table->string('request_id')->nullable();
			$table->integer('views')->default(1);
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
		Schema::drop('action_page');
	}

}
