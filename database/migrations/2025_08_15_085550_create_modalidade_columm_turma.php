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
        Schema::table('unidades', function (Blueprint $table) {
                    $table->dropForeign(['modalidade_id']);
                    $table->dropColumn('modalidade_id');
        });
        Schema::table('turmas', function (Blueprint $table) {
           $table->foreignUuid('modalidade_id')->nullable()->after('nome_turma')->constrained('modalidades')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modalidade_columm_turma');
    }
};
