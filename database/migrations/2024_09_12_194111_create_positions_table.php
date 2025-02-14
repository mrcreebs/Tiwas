<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('angebot_id'); // Verknüpfung mit Angebot
            $table->integer('position'); // Reihenfolge der Positionen
            $table->text('kopftext')->nullable(); // Optionaler Kopftext
            $table->text('fusstext')->nullable(); // Optionaler Fußtext
            $table->decimal('rabatt', 5, 2)->nullable(); // Optionaler Rabatt
            $table->timestamps();

            // Fremdschlüssel für Angebot
            $table->foreign('angebot_id')->references('id')->on('angebots')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};

