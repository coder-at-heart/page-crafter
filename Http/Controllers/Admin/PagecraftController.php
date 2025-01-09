<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Pagecraft\Enums\PageStatus;
use App\Modules\Pagecraft\Http\Requests\PageRequest;
use App\Modules\Pagecraft\Models\Page;
use App\Modules\Pagecraft\Pagecraft;
use Arr;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Throwable;

class PagecraftController extends Controller
{
    public function index(): View
    {
        Pagecraft::load();
        Pagecraft::createAllFixedPages();

        // Ensure custom fields are last
        $pages = Page::orderByRaw("FIELD(template, 'custom') ASC")->get();

        return view('pagecraft::admin.index', [
            'pages' => $pages,
        ]);
    }

    public function create() //phpcs:ignore
    {
        Pagecraft::load();
        $template = Pagecraft::getTemplate('custom');

        $page = Page::create([
            'title'    => 'New Page',
            'admin_id' => request()->user()->id,
            'status'   => PageStatus::DRAFT,
            'template' => $template->getType(),
            'content'  => [],
        ]);

        return redirect()->route('admin.pagecraft.edit', $page);
    }

    public function edit(Page $page): View
    {
        Pagecraft::load();
        $template = Pagecraft::getTemplate($page->template);

        return view('pagecraft::admin.edit', [
            'components' => $template->getValidComponentsList(),
            'mode'       => 'edit',
            'fixed'      => $template->is_fixed ? 'yes' : 'no',
            'page'       => $page->load('admin'),
        ]);
    }

    public function update(PageRequest $pageRequest, Page $page): JsonResponse
    {
        Pagecraft::load();

        $errors = [];
        foreach ($pageRequest->input('content') as $content) {
            $component = Pagecraft::getComponent($content['type']);
            try {
                Validator::validate($content['data'], $component->rules(), $component->errorMessages());
            } catch (ValidationException $e) {
                $expandedErrors = [];

                foreach ($e->errors() as $key => $messages) {
                    // Expand dot notation into a nested array
                    Arr::set($expandedErrors, $key, $messages);
                }

                $errors[$content['id']] = $expandedErrors;
            }
        }
        if (count($errors) > 0) {
            return response()->json([
                'success' => false,
                'errors' => $errors,
            ]);
        }

        $page->update([
            'content' => $pageRequest->input('content'),
            'title'   => $pageRequest->input('title'),
            'status'  => $pageRequest->input('status'),
            'slug'    => $pageRequest->input('slug'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Page updated successfully.',
        ]);
    }

    public function destroy(Page $page): JsonResponse
    {
        try {
            $page->delete();
            return response()->json(['success' => true, 'message' => 'Page deleted successfully.']);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete page.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
