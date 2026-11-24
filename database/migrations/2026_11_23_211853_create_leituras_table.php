<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leituras', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('livro_id')
                ->constrained('livros')
                ->restrictOnDelete();

            $table->enum('status', [
                'quero_ler',
                'lendo',
                'lido',
                'abandonado',
            ])->default('quero_ler');

            $table->date('data_inicio')->nullable();
            $table->date('data_conclusao')->nullable();

            $table->timestamps();

            $table->unique(['user_id', 'livro_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leituras');
    }
};
