<?php

namespace App\Modules\Pagecraft\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $guarded = [
        'id',
    ];

    protected $appends = [
        'path',
        'url',
    ];

    public function getPathAttribute(): string
    {
        return Storage::disk($this->disk)->path("{$this->folder}/{$this->name}");
    }

    public function getUrlAttribute(): string
    {
        return route('admin.pagecraft.media.show', $this);
    }
}
