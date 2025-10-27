<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('collaborator_contracts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('collaborator_id')->unsigned();
            $table->bigInteger('position_id')->unsigned();
            $table->integer('salary')->unsigned();
            $table->bigInteger('contract_type_id')->unsigned();
            $table->date('contract_start_date');
            $table->date('contract_end_date')->nullable();
            $table->date('test_period_end_date')->nullable();
            $table->text('observations')->nullable();

            $table->foreign('collaborator_id')->references('id')->on('collaborators')->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
            $table->foreign('contract_type_id')->references('id')->on('contract_types')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('collaborator_contracts');
    }
};
