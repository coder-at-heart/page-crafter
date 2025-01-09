<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Components;

use App\Modules\Pagecraft\Components\Concerns\Component;

class Pullout extends Component
{
    public function rules(): array
    {
        return [
            'text' => 'required',
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
