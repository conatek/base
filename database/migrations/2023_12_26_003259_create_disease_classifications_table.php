<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('disease_classifications', function (Blueprint $table) {
            $table->id();
            $table->string('cie_code');
            $table->string('description');
            $table->string('group');
            $table->string('segment');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('disease_classifications');
    }
};
