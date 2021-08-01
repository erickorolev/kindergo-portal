<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignsToChildTripTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('child_trip', function (Blueprint $table) {
            $table
                ->foreign('child_id')
                ->references('id')
                ->on('children')
                ->onUpdate('CASCADE');

            $table
                ->foreign('trip_id')
                ->references('id')
                ->on('trips')
                ->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('child_trip', function (Blueprint $table) {
            $table->dropForeign(['child_id']);
            $table->dropForeign(['trip_id']);
        });
    }
}
