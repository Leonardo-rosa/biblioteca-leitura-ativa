
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('perfil')
                ->default('integrante')
                ->after('password');

            $table->boolean('ativo')
                ->default(true)
                ->after('perfil');

            $table->index(['perfil', 'ativo']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['perfil', 'ativo']);
            $table->dropColumn(['perfil', 'ativo']);
        });
    }
};
