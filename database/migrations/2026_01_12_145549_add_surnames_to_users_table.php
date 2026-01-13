<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Agregamos los apellidos como nullables y ordenados
            $table->string('first_surname')->nullable()->after('name');
            $table->string('second_surname')->nullable()->after('first_surname');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Eliminamos las columnas si se revierte la migración
            $table->dropColumn(['first_surname', 'second_surname']);
        });
    }
};
