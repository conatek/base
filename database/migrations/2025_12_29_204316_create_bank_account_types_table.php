<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bank_account_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Insertamos los valores de una vez para que la tabla no esté vacía
        DB::table('bank_account_types')->insert([
            ['name' => 'Ahorros', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Corriente', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'AFC', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_account_types');
    }
};
