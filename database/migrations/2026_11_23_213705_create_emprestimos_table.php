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
        Schema::create('emprestimos', function (Blueprint $table) {
        $table->id();

        $table->foreignId('exemplar_id')
            ->constrained('exemplars')
            ->restrictOnDelete();

        $table->foreignId('user_id')
            ->constrained('users')
            ->restrictOnDelete();

        $table->date('data_emprestimo');
        $table->date('data_prevista_devolucao');
        $table->date('data_devolucao')->nullable();

        $table->timestamps();

        $table->index(['exemplar_id', 'data_devolucao']);
        $table->index(['user_id', 'data_emprestimo']);
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emprestimos');
        
    }
};
