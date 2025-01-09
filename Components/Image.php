<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Components;

use App\Modules\Pagecraft\Components\Concerns\Component;
use App\Modules\Pagecraft\Models\Media;
use Illuminate\Validation\Rule;

class Image extends Component
{
    public function rules(): array
    {
        return [
            'media_id' => ['required', Rule::exists('media', 'id')],
            'caption'  => ['nullable', 'string'],
        ];
    }

    public function content(array $content): array
    {
        $media = Media::find($content['data']['media_id']);

        return [
            "type"    => $content['type'],
            "variant" => $content['variant'],
            "data"    => [
                'hash'    => $media->thumb_hash,
                'url'     => $media->url,
                'caption' => $content['data']['caption'],
            ],
        ];
    }
}
