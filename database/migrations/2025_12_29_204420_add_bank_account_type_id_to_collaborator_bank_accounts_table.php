<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('collaborator_bank_accounts', function (Blueprint $table) {
            // 1. Creamos la columna permitiendo valores nulos inicialmente o con un default
            $table->unsignedBigInteger('bank_account_type_id')
                ->nullable() // Lo hacemos nullable primero para no romper registros existentes
                ->after('bank_id');
        });

        // 2. Opcional: Asignar un valor por defecto (ID 1 = Ahorros) a los registros que ya existen
        DB::table('collaborator_bank_accounts')
            ->whereNull('bank_account_type_id')
            ->update(['bank_account_type_id' => 1]);

        // 3. Ahora que todos los registros tienen un valor válido, aplicamos la restricción
        Schema::table('collaborator_bank_accounts', function (Blueprint $table) {
            $table->foreign('bank_account_type_id', 'col_bank_accounts_type_foreign')
                ->references('id')
                ->on('bank_account_types')
                ->onUpdate('no action')
                ->onDelete('no action');
                
            // Si quieres que en el futuro sea obligatorio, puedes cambiarlo aquí:
            // $table->unsignedBigInteger('bank_account_type_id')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('collaborator_bank_accounts', function (Blueprint $table) {
            // Primero eliminamos la llave foránea y luego la columna
            $table->dropForeign('col_bank_accounts_type_foreign');
            $table->dropColumn('bank_account_type_id');
        });
    }
};