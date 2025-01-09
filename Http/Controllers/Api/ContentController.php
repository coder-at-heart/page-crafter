<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContentResource;
use App\Modules\Pagecraft\Models\Page;
use App\Modules\Pagecraft\Pagecraft;
use Illuminate\Http\JsonResponse;

class ContentController extends Controller
{
    public function __invoke(Page $page): JsonResponse
    {
        Pagecraft::load();
        return response()->json([ContentResource::make($page)]);
    }
}
