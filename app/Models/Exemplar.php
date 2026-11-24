<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exemplar extends Model
{
    protected $fillable = [
        'livro_id',
        'codigo',
        'ativo',
    ];

    protected function casts(): array
    {
        return [
            'ativo' => 'boolean',
        ];
    }

    public function livro(): BelongsTo
    {
        return $this->belongsTo(Livro::class);
    }

    public function emprestimos()
        {
            return $this->hasMany(Emprestimo::class);
        }
}
