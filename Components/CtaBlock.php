<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Components;

use App\Modules\Pagecraft\Components\Concerns\Component;
use App\Modules\Pagecraft\Enums\LinkType;
use App\Modules\Pagecraft\Pagecraft;
use Illuminate\Validation\Rule;

class CtaBlock extends Component
{
    public function rules(): array
    {
        return [
            'buttons'           => ['required', 'array'],
            'buttons.*.href'    => ['required', 'string'],
            'buttons.*.content' => ['required', 'string'],
            'buttons.*.type'    => ['required', 'string', Rule::in(LinkType::getValues())],
            'buttons.*.icon'    => ['nullable', 'string', Rule::in(Pagecraft::icons())],
        ];
    }

    public function errorMessages(): array
    {
        return [
            'buttons.required'  => 'Please add at least one button.',
            'buttons.*.href'    => 'This field is required.',
            'buttons.*.content' => 'This field is required.',
        ];
    }

    public function getName(): string
    {
        return 'CTA Block';
    }

    public function config(): array
    {
        $button = app(Button::class);
        return $button->config();
    }

    public function content(array $content): array
    {
        return [
            "type"    => $content['type'],
            "variant" => $content['variant'],
            "data"    => [
                'buttons' => $content['data']['buttons'],
            ],
        ];
    }
}
