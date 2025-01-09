<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Components;

use App\Modules\Pagecraft\Components\Concerns\Component;
use Illuminate\Validation\Rule;

class Activity extends Component
{
    public function rules(): array
    {
        return [
            'type' => ['required', Rule::in(['specific', 'next'])],
            'id'   => ['nullable', 'integer', Rule::in([101, 220])],
        ];
    }

    public function variants(): array
    {
        return [
            'one' => 'One',
            'two' => 'Two',
        ];
    }

    public function config(): array
    {
        return [
            'types'      => [
                'next'     => 'Next',
                'specific' => 'Specific',
            ],
            'activities' => [
                101 => 'Golfing',
                220 => 'Breakfast',
            ],
        ];
    }

    public function content(array $content): array
    {
        // Pull the correct activity.
        $activity = [
            'id'          => 101,
            'type'        => '',
            'name'        => '',
            'description' => '',
            'link'        => null,
            'image'       => null,
            'location'    => null,
            'capacity'    => 200,
            'optional'    => 0,
            'date'        => null,
            'start_time'  => null,
            'end_time'    => null,
            'duration'    => null,

        ];
        return [
            "type"    => $content['type'],
            "variant" => $content['variant'],
            "data"    => [
                'type'     => $content['data']['type'],
                'activity' => $activity,
            ],
        ];
    }
}
