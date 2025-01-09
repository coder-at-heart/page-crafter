<?php

namespace App\Modules\Pagecraft\Http\Requests;

use App\Modules\Pagecraft\Enums\PageStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return is_admin();
    }

    public function rules(): array
    {
        return [
            'id'                => ['required', Rule::exists('pages', 'id')],
            'title'             => ['required', 'string', 'max:255'],
            'status'            => ['required', Rule::in(PageStatus::getValues())],
            'content'           => ['sometimes', 'array'],
            'content.*.id'      => ['required', 'string'],
            'content.*.type'    => ['required', 'string'],
            'content.*.variant' => ['nullable', 'string'],
            'content.*.data'    => [
                'sometimes', function ($attribute, $value, $fail): void {
                    if (is_array($value) || is_object($value)) {
                        return;
                    }

                    $fail($attribute.' must be an array or object.');
                },
            ],
        ];
    }
}
