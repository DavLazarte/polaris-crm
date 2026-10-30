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
        Schema::create('convocatorias', function (Blueprint $table) {
            $table->id();

            // Campos principales del JSON de n8n (Gemini)
            $table->string('titulo')->nullable();
            $table->text('resumen')->nullable();
            $table->date('fecha_limite')->nullable();
            $table->date('fecha_public')->nullable();

            // Presupuesto / Montos
            $table->decimal('presupuesto_min', 15, 2)->nullable();
            $table->decimal('presupuesto_max', 15, 2)->nullable();
            $table->string('moneda', 50)->nullable();
            $table->string('presup_texto')->nullable();

            // Listas estructuradas (Arrays JSON)
            $table->json('sector_elegible')->nullable();
            $table->json('tipo_benef')->nullable();
            $table->json('ods')->nullable();

            // Clasificación y alcance
            $table->string('modalidad')->nullable();
            $table->string('ambito_geo')->nullable();
            $table->string('alcance_region')->nullable();
            $table->boolean('alcance_arg')->default(false);

            // Control de calidad de IA (n8n)
            $table->boolean('requiere_revision_vigencia')->default(false);
            $table->decimal('score_conf', 4, 2)->nullable();
            $table->boolean('error_parseo')->default(false);
            $table->longText('texto_crudo')->nullable();

            // Campos complementarios / opcionales para enriquecer desde Filament o futura mejora de n8n
            $table->string('organismo')->nullable();
            $table->string('link', 500)->nullable();
            $table->string('fuente')->nullable();
            $table->text('requisitos')->nullable();

            // Estado de publicación en el frontend (/radar)
            $table->boolean('is_published')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convocatorias');
    }
};
