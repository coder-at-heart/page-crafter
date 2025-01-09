<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Components;

use App\Modules\Pagecraft\Components\Concerns\Component;

class Accordion extends Component
{
    public function rules(): array
    {
        return [
            'items'                 => ['required', 'array'],
            'items.*.title'         => ['required', 'string'],
            'items.*.text'          => ['required', 'array'],
            'items.*.text.html'     => ['required', 'string'],
            'items.*.text.markdown' => ['required', 'string'],
            'items.*.open'          => ['required', 'boolean'],
        ];
    }

    public function errorMessages(): array
    {
        return [
            'items'          => "You'll need at least one accordion item",
            'items.*.title'  => "The title field is required",
            'items.*.text.*' => "The text field is required",
        ];
    }

    public function content(array $content): array
    {
        return [
            "type"    => $content['type'],
            "variant" => $content['variant'],
            "data"    => [
                'slides' => $content['data']['items'],
            ],
        ];
    }
}
