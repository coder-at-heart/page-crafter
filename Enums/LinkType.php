<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Enums;

use MabeEnum\Enum;

class LinkType extends Enum
{
    public const EXTERNAL  = 'external';
    public const ROUTE     = 'route';
    public const PAGE      = 'page';
    public const EMAIL     = 'email';
    public const TELEPHONE = 'tel';

    public static function toArray(): array
    {
        return [
            self::EXTERNAL  => 'External',
            self::ROUTE     => 'Route',
            self::PAGE      => 'Page',
            self::EMAIL     => 'Email',
            self::TELEPHONE => 'Telephone',
        ];
    }
}
