<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('angebots_artikels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('position_id'); // Verknüpfung mit Position
            $table->unsignedBigInteger('artikel_id');  // Verknüpfung mit Artikel
            $table->boolean('aktiv')->default(true);  // Position aktiv
            $table->string('artikelbeschreibung')->nullable(); // Artikelbeschreibung
            $table->string('image')->nullable(); // Bild
            $table->enum('kategorie', ["service","physikal"]); // Kategorie
            $table->integer('menge'); // Menge des Artikels
            $table->decimal('einzelpreis', 8, 2); // Einzelpreis des Artikels
            $table->decimal('gesamtpreis', 10, 2); // Gesamtpreis (menge * einzelpreis)
            $table->timestamps();

            // Fremdschlüssel für Position
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
            // Fremdschlüssel für Artikel
            $table->foreign('artikel_id')->references('id')->on('artikels')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('angebots_artikels');
    }
};

