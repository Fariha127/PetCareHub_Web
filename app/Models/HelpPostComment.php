<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HelpPostComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'help_post_id',
        'user_id',
        'content',
    ];

    public function helpPost(): BelongsTo
    {
        return $this->belongsTo(HelpPost::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
