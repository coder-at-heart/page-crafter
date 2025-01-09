<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Components;

use App\Modules\Pagecraft\Components\Concerns\Component;
use App\Modules\Pagecraft\Models\Media;
use Illuminate\Validation\Rule;

class Onboarding extends Component
{
    public function rules(): array
    {
        return [
            'slides'            => ['required', 'array', 'min:4'],
            'slides.*.title'    => ['required', 'string'],
            'slides.*.media_id' => ['required', Rule::exists('media', 'id')],
            'slides.*.body'     => ['required', 'string'],
        ];
    }

    public function errorMessages(): array
    {
        return [
            'slides.*.title'    => 'The title is required',
            'slides.*.body'     => 'The body is required',
            'slides.*.media_id' => 'Please provide an asset',
        ];
    }

    public function default(): array
    {
        return [
            'slides' => [
                [
                    'title'    => '',
                    'media_id' => '',
                    'body'     => '',
                ],
                [
                    'title'    => '',
                    'media_id' => '',
                    'body'     => '',
                ],
                [
                    'title'    => '',
                    'media_id' => '',
                    'body'     => '',
                ],
                [
                    'title'    => '',
                    'media_id' => '',
                    'body'     => '',
                ],
            ],
        ];
    }

    public function content(array $content): array
    {
        $response = [
            'slides'  => [],
            'type'    => $this->getType(),
            'variant' => '',
        ];
        foreach ($content['data']['slides'] as $slide) {
            $media                = Media::find($slide['media_id']);
            $response['slides'][] = [
                'image' => [
                    'hash' => $media ? $media->thumb_hash : '',
                    'url'  => $media ? $media->url : '',
                ],
                'title' => $slide['title'],
                'body'  => $slide['body'],
            ];
        }
        return $response;
    }
}
