<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogsNews extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'news_id', 'action', 'details'];

    protected $with = ['user', 'news'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class, 'news_id');
    }
}
