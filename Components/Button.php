<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Components;

use App\Modules\Pagecraft\Components\Concerns\Component;
use App\Modules\Pagecraft\Enums\LinkType;
use App\Modules\Pagecraft\Enums\PageStatus;
use App\Modules\Pagecraft\Models\Page;
use App\Modules\Pagecraft\Pagecraft;
use Illuminate\Validation\Rule;

class Button extends Component
{
    public function rules(): array
    {
        return [
            'href'    => ['required', 'string'],
            'content' => ['required', 'string'],
            'type'    => ['required', 'string', Rule::in(LinkType::getValues())],
            'icon'    => ['nullable', 'string', Rule::in(Pagecraft::icons())],
        ];
    }

    public function errorMessages(): array
    {
        return [
            'href'    => 'This field is required.',
            'content' => 'Button text is required.',
        ];
    }

    public function config(): array
    {
        return [
            'types'  => LinkType::toArray(),
            'icons'  => Pagecraft::icons(),
            'routes' => Pagecraft::routes(),
            'pages'  => Page::whereStatus(PageStatus::PUBLISHED)->orderBy('title')->get(['slug', 'title'])->toArray(),
        ];
    }
}
