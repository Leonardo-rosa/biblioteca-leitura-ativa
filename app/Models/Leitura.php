<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Leitura extends Model
{
    protected $fillable = [
        'user_id',
        'livro_id',
        'status',
        'data_inicio',
        'data_conclusao',
    ];

    protected function casts(): array
    {
        return [
            'data_inicio' => 'date',
            'data_conclusao' => 'date',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function livro(): BelongsTo
    {
        return $this->belongsTo(Livro::class);
    }
}
