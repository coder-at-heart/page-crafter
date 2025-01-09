<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Templates;

use App\Modules\Pagecraft\Components\Heading;
use App\Modules\Pagecraft\Components\Text;
use App\Modules\Pagecraft\Templates\Concerns\Template;

class DashboardTemplate extends Template
{
    public function validComponents(): array
    {
        return [
            Text::class,
            Heading::class,
            Text::class,
        ];
    }
}
