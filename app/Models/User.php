<?php
namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'perfil',
        'ativo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'ativo' => 'boolean',
        ];
    }

    /**
     * Verifica se o usuário é administrador.
     */
    public function isAdministrador(): bool
    {
        return $this->perfil === 'administrador';
    }

    /**
     * Verifica se o usuário é integrante.
     */
    public function isIntegrante(): bool
    {
        return $this->perfil === 'integrante';
    }

    /**
     * Verifica se o usuário pode acessar o sistema.
     */
    public function estaAtivo(): bool
    {
        return $this->ativo === true;
    }
}
