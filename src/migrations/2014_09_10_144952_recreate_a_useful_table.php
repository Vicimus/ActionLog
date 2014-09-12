<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecreateAUsefulTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::drop('action_page');

		Schema::create('action_page', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('page_id');
			$table->string('session_id');
			$table->timestamps();

		});

		Schema::create('action_page_vehicle', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('vehicle_id');
			$table->string('session_id');
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
		
	}

}
