<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tmp_collaborator_imports', function (Blueprint $table) {
            $table->id();
            $table->string('company_id')->nullable();
            $table->string('document_type')->nullable();
            $table->string('document_number')->nullable();
            $table->string('expedition_date')->nullable();
            $table->string('document_province')->nullable();
            $table->string('document_city')->nullable();
            $table->string('name')->nullable();
            $table->string('first_surname')->nullable();
            $table->string('second_surname')->nullable();
            $table->string('civil_status_type')->nullable();
            $table->string('sex_type')->nullable();
            $table->string('rh_type')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('birth_province')->nullable();
            $table->string('birth_city')->nullable();
            $table->string('residence_province')->nullable();
            $table->string('residence_city')->nullable();
            $table->string('address')->nullable();
            $table->string('housing_tenure')->nullable();
            $table->string('stratum_type')->nullable();
            $table->string('phone')->nullable();
            $table->string('cellphone')->nullable();
            $table->string('email')->nullable();
            $table->text('observations')->nullable();
            $table->longText('errors')->nullable();
            $table->text('hash');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tmp_collaborator_imports');
    }
};
