<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStackTraceToLog extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('action_log', function(Blueprint $table)
		{
			$table->text("stack_trace")->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('action_log', function(Blueprint $table)
		{
			$table->dropColumn("stack_trace");
		});
	}

}
