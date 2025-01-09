<?php

namespace App\Modules\Pagecraft\Enums;

use MabeEnum\Enum;

class PageStatus extends Enum
{
    public const DRAFT     = 'draft';
    public const PUBLISHED = 'published';
    public const ARCHIVED  = 'archived';
}
