<?php

namespace App\Modules\Pagecraft\Services;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Thumbhash\Thumbhash;
use function Thumbhash\extract_size_and_pixels_with_gd;

class MediaServices
{
    public static function createThumbHash(string $contents): string
    {
        //  Resize to 100,100 to we can build a thumb hash
        $manager = new ImageManager(new Driver());
        $image   = $manager->read($contents);
        $image->cover(100, 100);
        $imageContents = (string) $image->encode();

        [$width, $height, $pixels] = extract_size_and_pixels_with_gd($imageContents);
        $hash = Thumbhash::RGBAToHash($width, $height, $pixels);
        return Thumbhash::convertHashToString($hash);
    }
}
