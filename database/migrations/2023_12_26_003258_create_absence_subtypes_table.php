<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('absence_subtypes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('absence_type_id');
            $table->string('subtype');

            $table->foreign('absence_type_id')->references('id')->on('absence_types');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('absence_subtypes');
    }
};
