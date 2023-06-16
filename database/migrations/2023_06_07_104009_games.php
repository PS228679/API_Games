<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id('id');
            $table->string('naam', 50)->nullable(false);
            $table->unsignedBigInteger('dev_id');
            $table->date('release_date', 50)->nullable(true);
            $table->string('platform', 50)->nullable(true);

            $table->foreign('dev_id')->references('id')->on('developers')->restrictOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('games');
    }
};
