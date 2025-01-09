<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Enums;

use MabeEnum\Enum;

class VideoProvider extends Enum
{
    public const VIMEO   = 'vimeo';
    public const YOUTUBE = 'youtube';

    public static function toArray(): array
    {
        return [
            self::VIMEO   => 'Vimeo',
            self::YOUTUBE => 'YouTube',
        ];
    }
}
