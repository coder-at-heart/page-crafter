<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Components;

use App\Modules\Pagecraft\Components\Concerns\Component;
use App\Modules\Pagecraft\Enums\VideoProvider;
use App\Modules\Pagecraft\Models\PagecraftVideo;
use App\Modules\Pagecraft\Services\MediaServices;
use Embed\Embed;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Throwable;

class Video extends Component
{
    public function rules(): array
    {
        return [
            'provider' => ['required', Rule::in(VideoProvider::getValues())],
            'code'     => ['required', 'string'],
            'autoplay' => ['nullable', 'bool'],
        ];
    }

    public function errorMessages(): array
    {
        return [
            'code' => 'please provide a valid video id',
        ];
    }

    public function config(): array
    {
        return [
            'providers' => VideoProvider::toArray(),
        ];
    }

    public function content(array $content): array
    {
        $code     = $content['data']['code'];
        $provider = $content['data']['provider'];

        $video = PagecraftVideo::where('code', $code)
            ->where('provider', $provider)
            ->first();

        try {
            if (! $video) {
                $embed = new Embed();

                $url  = $provider === 'vimeo' ? "https://www.vimeo.com/$code" : "youtube.com/watch?v=$code";
                $info = $embed->get($url);

                $thumbnail = $info->image;
                if ($thumbnail) {
                    $contents  = file_get_contents((string) $thumbnail);
                    $thumbHash = MediaServices::createThumbHash($contents);
                }

                $video = PagecraftVideo::create([
                    'provider'    => $provider,
                    'code'        => $code,
                    'url'         => $url,
                    'thumbnail'   => $thumbnail,
                    'thumb_hash'  => $thumbHash ?? null,
                    'title'       => $info->title,
                    'height'      => $info->code?->height,
                    'width'       => $info->code?->width,
                    'description' => $info->description,
                ]);
            }

            return [
                "type" => $content['type'],
                "variant" => $content['variant'],
                "data" => [
                    "provider"    => $provider,
                    'url'         => $video->url,
                    'hash'        => $video->thumb_hash,
                    'title'       => $video->title,
                    'thumbnail'   => $video->thumbnail,
                    'description' => $video->description,
                    'height'      => $video->height,
                    'width'       => $video->width,
                    'autoplay'    => $content['autoplay'] ?? false,
                ],
            ];
        } catch (Throwable $e) {
            Log::error($e->getMessage());

            return [];
        }
    }
}
