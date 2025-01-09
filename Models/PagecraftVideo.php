<?php

namespace App\Modules\Pagecraft\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PagecraftVideo extends Model
{
    protected $guarded = [
        'id',
    ];

    public function media(): HasOne
    {
        return $this->hasOne(Media::class);
    }
}
