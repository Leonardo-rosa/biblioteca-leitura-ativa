<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Emprestimo extends Model
{
    protected $fillable = [
        'exemplar_id',
        'user_id',
        'data_emprestimo',
        'data_prevista_devolucao',
        'data_devolucao',
    ];

    protected function casts(): array
    {
        return [
            'data_emprestimo' => 'date',
            'data_prevista_devolucao' => 'date',
            'data_devolucao' => 'date',
        ];
    }

    public function exemplar(): BelongsTo
    {
        return $this->belongsTo(Exemplar::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}