<?php

namespace App\Modules\Pagecraft\Database\Seeds;

use App\EnvX\Database\AutoSeed;
use App\Modules\Pagecraft\Models\Page;

class PageSeeder extends AutoSeed
{
    public function run(): void
    {
        $this->refresh(Page::class);
    }
}
