<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('developers', function (Blueprint $table) {
            $table->id('id');
            $table->string('naam', 50)->nullable(false)->unique()->required();
        });
    }

    public function down()
    {
        Schema::dropIfExists('developers');
    }
};
