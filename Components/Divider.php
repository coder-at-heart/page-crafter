<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Components;

use App\Modules\Pagecraft\Components\Concerns\Component;

class Divider extends Component
{
    public function content(array $content): array
    {
        return [
            "type"    => $content['type'],
            "variant" => $content['variant'],
        ];
    }
}
