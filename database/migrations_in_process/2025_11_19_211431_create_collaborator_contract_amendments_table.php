<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collaborator_contract_amendments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('collaborator_contract_id')->unsigned();
            $table->bigInteger('new_position_id')->nullable()->unsigned();

            $table->string('amendment_type', 50); // 'PRORROGA', 'MODIFICACION_SALARIO', 'TERMINACION', 'SUSPENSION', etc.
            $table->date('amendment_date');
            $table->date('new_contract_end_date')->nullable(); // Para 'PRORROGA', 'TERMINACION' o 'SUSPENSION'
            $table->unsignedInteger('new_salary')->nullable(); // Para 'MODIFICACION_SALARIO'
            $table->string('related_file_public_id')->nullable();
            $table->string('related_file_url')->nullable();
            $table->text('observations')->nullable();

            // Llaves foráneas
            $table->foreign('collaborator_contract_id')->references('id')->on('collaborator_contracts')->onDelete('cascade');
            $table->foreign('new_position_id')->references('id')->on('positions')->onDelete('restrict');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collaborator_contract_amendments');
    }
};
