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
        Schema::create('alunos', function (Blueprint $table) {
           $table->uuid('id')->primary();
            $table->string('nome_aluno');
            $table->unsignedBigInteger('user_id');
            $table->uuid('unidade_id');
            $table->uuid('turma_id');
            $table->boolean('ativo')->default(true);
            $table->date('data_nascimento');
            $table->string('cpf',11)->unique();
            $table->string('email')->nullable();
            $table->integer('idade');
            $table->integer('sexo');
            $table->string('telefone',11);
            $table->string('endereco');
            $table->string('bairro');
            $table->string('cidade');
            $table->string('cep',8);
            $table->string('estado');
            $table->boolean('possui_responsavel')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('unidade_id')->references('id')->on('unidades');
            $table->foreign('turma_id')->references('id')->on('turmas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alunos');
    }
};
