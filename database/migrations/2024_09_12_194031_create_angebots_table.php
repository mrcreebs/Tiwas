<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('angebots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kunde_id');
            $table->decimal('gesamtbetrag', 10, 2)->nullable();
            $table->timestamps();

            // Fremdschlüssel für Kunde
            $table->foreign('kunde_id')->references('id')->on('kundes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('angebots');
    }
};

