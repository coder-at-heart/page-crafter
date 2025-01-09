<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Components;

use App\Modules\Pagecraft\Components\Concerns\Component;

class Heading extends Component
{
    public function rules(): array
    {
        return [
            'level' => 'required', 'string', 'between:1,3',
            'text'  => 'required', 'string',
        ];
    }

    public function errorMessages(): array
    {
        return [
            'level' => 'The level field is required.',
            'text'  => 'The title field is required.',
        ];
    }

    public function default(): array
    {
        return [
            'text'  => 'This is a heading',
            'level' => "1",
        ];
    }
}
