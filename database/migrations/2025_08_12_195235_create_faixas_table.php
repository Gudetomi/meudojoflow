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
        Schema::create('faixas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('modalidade_id')->constrained('modalidades')->onDelete('cascade');
            
            $table->string('nome'); 
            $table->integer('ordem');
            
            $table->string('cor_principal')->nullable();   
            $table->string('cor_secundaria')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faixas');
    }
};
