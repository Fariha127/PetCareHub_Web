<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HelpPostImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'help_post_id',
        'image_path',
    ];

    public function helpPost(): BelongsTo
    {
        return $this->belongsTo(HelpPost::class);
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->image_path);
    }
}
