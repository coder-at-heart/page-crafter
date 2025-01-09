<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Templates;

use App\Modules\Pagecraft\Templates\Concerns\Template;

class CustomTemplate extends Template
{
    public bool $is_fixed = false;
}
