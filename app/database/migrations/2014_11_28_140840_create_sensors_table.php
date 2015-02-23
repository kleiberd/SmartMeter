<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSensorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
    public function up()
    {
        Schema::create('sensors', function(Blueprint $table)
        {
            $table->string('device_id');
            $table->string('name');
            $table->string('description');
            $table->string('unit');
            $table->float('latitude', 16, 14);
            $table->float('longitude', 16, 14);
            $table->timestamps();

            $table->primary('device_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sensors');
    }

}
