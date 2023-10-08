<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'user_id'];
    // protected $with = ['user', 'commentsss'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function logsnews()
    {
        return $this->hasMany(LogsNews::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comments::class);
    }

    // protected static function booted(): void
    // {
    //     static::addGlobalScope('user', function(Builder $builder) {
    //         $builder->where('user_id', Auth::id());
    //     });
    // }
}
