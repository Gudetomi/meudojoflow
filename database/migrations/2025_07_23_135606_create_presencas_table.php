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
            $table->uuid('aluno_id');
            $table->boolean('presente')->default(false);
             $table->date('data_presenca');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('aluno_id')->references('id')->on('alunos');
            $table->unique(['user_id', 'aluno_id', 'data_presenca']);
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
