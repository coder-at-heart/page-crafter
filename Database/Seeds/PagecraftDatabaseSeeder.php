<?php

namespace App\Modules\Pagecraft\Database\Seeds;

use Illuminate\Database\Seeder;

class PagecraftDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PageSeeder::class,
        ]);
    }
}
