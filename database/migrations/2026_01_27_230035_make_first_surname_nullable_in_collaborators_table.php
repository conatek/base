<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('collaborators', function (Blueprint $column) {
            $column->string('first_surname')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('collaborators', function (Blueprint $column) {
            $column->string('first_surname')->nullable(false)->change();
        });
    }
};
