<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('pay_date');
            $table->bigInteger('amount');
            $table->string('spstatus', 100)->default('Scheduled');
            $table
                ->string('attendanta_signature', 100)
                ->default('Waiting')
                ->nullable();
            $table->text('dispute_reason')->nullable();
            $table->string('pay_type', 50)->default('Expense');
            $table->unsignedBigInteger('user_id');
            $table->string('assigned_user_id')->default('19x1');
            $table->string('crmid', 50)->nullable();

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
        Schema::dropIfExists('payments');
    }
}
