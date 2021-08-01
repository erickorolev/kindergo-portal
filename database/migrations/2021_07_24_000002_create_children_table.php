<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('children', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('middle_name')->nullable();
            $table->date('birthday');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('phone', 20);
            $table->string('otherphone', 20)->nullable();
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
        Schema::dropIfExists('children');
    }
}
