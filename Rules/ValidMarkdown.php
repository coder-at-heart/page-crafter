<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidMarkdown implements Rule
{
    /**
     * Determine if the validation rule passes.
     */
    public function passes($attribute, $value): bool //phpcs:ignore
    {
        // Basic check: ensure it contains Markdown elements like headers, links, or lists.
        return preg_match('/(#|\*|-|\[.*]\(.*\))/', $value);
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'The :attribute must be valid Markdown.';
    }
}
