<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Components;

use App\Modules\Pagecraft\Components\Concerns\Component;

class DividerHeading extends Component
{
    public function rules(): array
    {
        return [
            'line1' => ['required', 'string'],
            'line2' => ['nullable', 'string'],
        ];
    }
}
