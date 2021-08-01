<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemporaryFileTable extends Migration
{
    public function up()
    {
        Schema::create('temporary_files', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('folder');
            $table->string('filename');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('temporary_files');
    }
}
