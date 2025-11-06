<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collaborator_bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('collaborator_id')->unsigned();
            $table->bigInteger('bank_id')->unsigned();
            $table->string('bank_account');
            $table->string('bank_certificate_public_id')->nullable();
            $table->string('bank_certificate_url')->nullable();
            $table->text('observations')->nullable();
            $table->timestamps();

            // Llaves foráneas
            $table->foreign('collaborator_id')->references('id')->on('collaborators');
            $table->foreign('bank_id')->references('id')->on('bank_types');

            // Un colaborador puede tener una sola cuenta bancaria principal
            $table->unique('collaborator_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collaborator_bank_accounts');
    }
};
