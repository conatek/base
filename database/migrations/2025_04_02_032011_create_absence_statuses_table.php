<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absence_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('absence_id');
            $table->unsignedBigInteger('absence_status_type_id');
            $table->integer('authorized_value')->nullable();
            $table->integer('paid_value')->nullable();
            $table->integer('paid_days')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('support_public_id')->nullable();
            $table->string('support_url')->nullable();
            $table->string('observations')->nullable();

            $table->foreign('absence_id')->references('id')->on('absences')->onDelete('cascade');
            $table->foreign('absence_status_type_id')->references('id')->on('absence_status_types')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absence_statuses');
    }
};
