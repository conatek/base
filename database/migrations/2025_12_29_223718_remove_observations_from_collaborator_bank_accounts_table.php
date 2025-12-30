<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('collaborator_bank_accounts', function (Blueprint $table) {
            $table->dropColumn('observations');
        });
    }

    public function down(): void
    {
        Schema::table('collaborator_bank_accounts', function (Blueprint $table) {
            $table->text('observations')->nullable()->after('bank_certificate_url');
        });
    }
};
