<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('collaborators', function (Blueprint $table) {
            // 1. Agregar la relación con Users
            $table->unsignedBigInteger('user_id')->nullable()->unique()->after('id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // 2. Volver NULLABLE los campos que no tenemos al crear el Admin
            // Nota: Necesitas el paquete 'doctrine/dbal' para modificar columnas: composer require doctrine/dbal
            
            $table->unsignedBigInteger('staff_provider_id')->nullable()->change();
            $table->unsignedBigInteger('document_type_id')->nullable()->change();
            $table->string('document_number')->nullable()->change();
            $table->unsignedBigInteger('document_province_id')->nullable()->change();
            $table->unsignedBigInteger('document_city_id')->nullable()->change();
            $table->unsignedBigInteger('civil_status_type_id')->nullable()->change();
            $table->unsignedBigInteger('sex_type_id')->nullable()->change();
            $table->unsignedBigInteger('rh_type_id')->nullable()->change();
            $table->unsignedBigInteger('residence_province_id')->nullable()->change();
            $table->unsignedBigInteger('residence_city_id')->nullable()->change();
            $table->unsignedBigInteger('housing_tenure_id')->nullable()->change();
            $table->unsignedBigInteger('stratum_type_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('collaborators', function (Blueprint $table) {
            // Revertir los cambios realizados en el método up
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            $table->unsignedBigInteger('staff_provider_id')->change();
            $table->unsignedBigInteger('document_type_id')->change();
            $table->string('document_number')->change();
            $table->unsignedBigInteger('document_province_id')->change();
            $table->unsignedBigInteger('document_city_id')->change();
            $table->unsignedBigInteger('civil_status_type_id')->change();
            $table->unsignedBigInteger('sex_type_id')->change();
            $table->unsignedBigInteger('rh_type_id')->change();
            $table->unsignedBigInteger('residence_province_id')->change();
            $table->unsignedBigInteger('residence_city_id')->change();
            $table->unsignedBigInteger('housing_tenure_id')->change();
            $table->unsignedBigInteger('stratum_type_id')->change();
        });
    }
};
