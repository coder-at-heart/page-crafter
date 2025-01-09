<?php

namespace App\Modules\Pagecraft\Models;

use App\Models\Admin;
use App\Modules\Pagecraft\Database\Factories\PageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Page extends Model
{
    use HasFactory;

    protected $casts = [
        'content' => 'array',
    ];

    protected $fillable = [
        'admin_id',
        'title',
        'template',
        'slug',
        'status',
        'content',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function newFactory(): PageFactory
    {
        return PageFactory::new();
    }

    protected static function booted(): void
    {
        static::creating(function (Page $page): void {
            if ($page->slug) {
                return;
            }

            // find the last "new Page" and add a number on it.
            $count      = Page::whereTitle('New Page')->count();
            $page->slug = 'new_page'.($count > 0 ? '_'.$count + 1 : '');
        });
    }
}
