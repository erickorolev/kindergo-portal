<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('where_address');
            $table->date('date');
            $table->time('time');
            $table->integer('childrens')->default(0);
            $table->integer('duration')->default(0);
            $table->decimal('distance');
            $table->string('status', 190)->default('Appointed');
            $table->integer('scheduled_wait_where');
            $table->integer('scheduled_wait_from');
            $table->integer('not_scheduled_wait_where')->nullable();
            $table->integer('not_scheduled_wait_from')->nullable();
            $table->integer('parking_cost')->nullable();
            $table->integer('attendant_income')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('crmid', 50)->nullable();
            $table->string('assigned_user_id')->default('19x1');
            $table->string('cf_timetable_id');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
}
