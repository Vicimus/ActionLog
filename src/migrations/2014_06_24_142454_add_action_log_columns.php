<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActionLogColumns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('action_log', function(Blueprint $table)
		{
			$table->string('package')->after('application');
			$table->text('post_data')->nullable();
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
			$table->dropColumn('package');
		});
	}

}
