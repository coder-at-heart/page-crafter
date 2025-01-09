<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Pagecraft\Models\Media;
use App\Modules\Pagecraft\Services\MediaServices;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function show(int $id) //phpcs:ignore
    {
        $media = Media::findOrFail($id);

        // Send file contents with appropriate mime type
        return response(Storage::disk($media->disk)->get($media->name), 200, [])
            ->header('Content-Type', $media->mime_type);
    }

    public function upload() //phpcs:ignore
    {
        $key          = request()->get('key');
        $originalName = request()->get('filename');
        $s3           = request()->get('s3');

        $contents = Storage::get($key);
        $md5      = md5($contents);
        $asset    = Media::where('hash', $md5)->first();

        if ($asset) {
            return $asset;
        }

        $thumbHash = MediaServices::createThumbHash($contents);
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $filename = pathinfo($originalName, PATHINFO_FILENAME);

        // Slugify only the filename part and keep the extension as it is
        $name = Str::slug($filename).'.'.$extension;

        $mime = Storage::mimeType($key);
        $size = Storage::size($key);
        $disk = $s3 ? 's3' : 'public';

        $destination = Storage::disk($disk)->path($name);

        File::put($destination, $contents);

        return Media::create([
            'name'       => $name,
            'folder'     => '',
            'hash'       => $md5,
            'thumb_hash' => $thumbHash,
            'disk'       => $disk,
            'mime_type'  => $mime,
            'size'       => $size,
        ]);
    }
}
