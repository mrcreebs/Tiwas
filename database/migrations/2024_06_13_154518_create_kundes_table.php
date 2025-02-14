<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kundes', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_business')->default(false);
            $table->foreignId('title_id')->nullable()->constrained('titles')->onDelete('set null');
            $table->string('vorname', 255)->nullable();
            $table->string('nachname', 255)->nullable();
            $table->string('bname', 255)->nullable()->unique(); // Firmenname als unique gesetzt
            $table->string('tel', 20)->nullable();
            $table->string('mobil', 20)->nullable();
            $table->string('email', 255)->nullable()->unique(); // E-Mail als unique gesetzt
            $table->string('ort', 255)->nullable();
            $table->string('street', 255)->nullable();
            $table->string('zip', 10)->nullable();
            $table->string('www', 255)->nullable();
            $table->string('bank', 255)->nullable();
            $table->string('iban', 34)->nullable(); // IBAN hat eine maximale Länge von 34 Zeichen
            $table->string('bic', 11)->nullable(); // BIC hat eine maximale Länge von 11 Zeichen
            $table->text('disc')->nullable(); // Notiz als Textfeld, falls längere Eingaben möglich sein sollen
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('kundes', function (Blueprint $table) {
        // Entferne den Foreign Key für 'title_id' bevor die Tabelle gelöscht wird
        $table->dropForeign(['title_id']);
    });
    
    // Lösche die Tabelle 'kundes'
    Schema::dropIfExists('kundes');
}
};

