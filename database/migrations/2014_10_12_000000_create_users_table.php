<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email', 190)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('remember_token', 100)->nullable();
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->foreignId('current_team_id')->nullable();
            $table->text('profile_photo_path')->nullable();
            $table->string('firstname', 190);
            $table->string('lastname', 190);
            $table->string('middle_name', 190)->nullable();
            $table->string('phone', 20);
            $table->string('otherphone', 20)->nullable();
            $table
                ->enum('gender', ['Male', 'Female', 'Other'])
                ->default('Other');
            $table
                ->string('attendant_category', 50)
                ->default('Other');
            $table
                ->string('attendant_status', 50)
                ->default('Active')
                ->nullable();
            $table->date('attendant_hired')->nullable();
            $table->date('birthday')->nullable();
            $table->string('mailingzip', 10)->nullable();
            $table->string('mailingstate', 190)->nullable();
            $table->string('mailingcountry', 190)->nullable();
            $table->string('mailingcity', 190)->nullable();
            $table->string('mailingstreet', 190)->nullable();
            $table->string('otherzip', 10)->nullable();
            $table->string('otherstate', 50)->nullable();
            $table->string('othercountry', 190)->nullable();
            $table->string('othercity', 190)->nullable();
            $table->string('otherstreet', 190)->nullable();
            $table->string('metro_station', 190)->nullable();
            $table->string('car_model', 100)->nullable();
            $table->string('car_year', 10)->nullable();
            $table->string('car_color', 190)->nullable();
            $table->text('resume')->nullable();
            $table->text('payment_data')->nullable();
            $table->string('crmid', 50)->nullable();
            $table->string('assigned_user_id')->default('19x1');

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
        Schema::dropIfExists('users');
    }
}
