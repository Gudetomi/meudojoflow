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
        Schema::create('presencas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id');
            $table->foreignUuid('aluno_id')->constrained('alunos')->onDelete('cascade');
            $table->foreignUuid('turma_id')->constrained('turmas')->onDelete('cascade');
            $table->boolean('presente')->default(false);
            $table->date('data_presenca');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('aluno_id')->references('id')->on('alunos');
            $table->unique(['aluno_id', 'turma_id', 'data_presenca']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presencas');
    }
};
