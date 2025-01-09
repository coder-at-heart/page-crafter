<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Components;

use App\Modules\Pagecraft\Components\Concerns\Component;

class Text extends Component
{
    public function rules(): array
    {
        return [
            'html'     => 'required', 'string',
            'markdown' => 'required', 'string',
        ];
    }

    public function errorMessages(): array
    {
        return [
            '*' => 'This field is required.',
        ];
    }

    public function default(): array
    {
        return [
            'html'     => '<p>This is some text</p>',
            'markdown' => 'This is some text',
        ];
    }

    public function variants(): array
    {
        return [
            'light'  => 'Light',
            'dark'   => 'Dark',
            'accent' => 'Accent',
        ];
    }
}
