<?php

namespace App\Modules\Pagecraft\Database\Factories;

use App\Models\Admin;
use App\Modules\Pagecraft\Enums\PageStatus;
use App\Modules\Pagecraft\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Page>
 */
class PageFactory extends Factory
{
    protected $model = Page::class;

    public function definition(): array
    {
        return [
            'slug' => $this->faker->unique()->word,
            'template' => 'custom',
            'status' => PageStatus::PUBLISHED,
            'title' => $this->faker->sentence,
            'content' => [],
            'admin_id' => Admin::factory(),
        ];
    }
}
