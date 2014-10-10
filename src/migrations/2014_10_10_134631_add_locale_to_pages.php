<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLocaleToPages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('action_page', function(Blueprint $table)
		{
			$table->string('locale', 2)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('action_page', function(Blueprint $table)
		{
			$table->dropColumn('locale');
		});
	}

}
