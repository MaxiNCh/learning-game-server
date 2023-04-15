<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'author_id',
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
