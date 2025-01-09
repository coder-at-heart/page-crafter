<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Enums;

use MabeEnum\Enum;

class Icon extends Enum
{
    public const SMILE = 'smile';
    public const SAD   = 'sad';

    public static function toArray(): array
    {
        return [
            self::SMILE => 'Smile',
            self::SAD   => 'Sad',
        ];
    }
}
