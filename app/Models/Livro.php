<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Livro extends Model
{
    protected $fillable = [
        'titulo',
        'autor',
        'genero',
        'editora',
        'isbn',
        'ativo',
    ];

    protected function casts(): array
    {
        return [
            'ativo' => 'boolean',
        ];
    }
    
    public function exemplares(): HasMany
    {
        return $this->hasMany(Exemplar::class);
    }
}
