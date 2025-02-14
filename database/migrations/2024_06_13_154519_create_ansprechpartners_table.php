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
        Schema::create('ansprechpartners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kunde_id');
            $table->enum('position', ['Manager', 'Leiter', 'Mitarbeiter', 'Assistent']);
            $table->string('vorname');
            $table->string('nachname');
            $table->string('email')->unique()->nullable();
            $table->string('ort')->nullable();
            $table->string('street')->nullable();
            $table->string('zip')->nullable();
            $table->string('mobil')->nullable();
            $table->string('tel')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Add foreign key constraint
            $table->foreign('kunde_id')->references('id')->on('kundes')->onDelete('cascade');
            $table->foreignId('title_id')->nullable()->constrained('titles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('ansprechpartners', function (Blueprint $table) {
        // Entfernt die Fremdschlüssel, bevor die Tabelle gelöscht wird
        $table->dropForeign(['kunde_id']);
        $table->dropForeign(['title_id']);
    });

    Schema::dropIfExists('ansprechpartners');
}
};
