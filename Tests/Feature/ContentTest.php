<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Tests\Feature;

use App\Models\User;
use App\Modules\Pagecraft\Models\Page;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Spatie\Snapshots\MatchesSnapshots;
use Tests\TestCase;

class ContentTest extends TestCase
{
    use MatchesSnapshots, RefreshDatabase;

    /** @test */
    public function it_returns_an_array_of_cms_components(): void
    {
        Carbon::setTestNow('2024-01-01 09:00');

        Passport::actingAs(User::factory()->create());

        $page = Page::factory()->create([
            'title' => 'Title',
            'slug' => 'slug',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $response = $this->getJson(route('api.cms.content', $page));

        $response->assertStatus(200);
        $this->assertMatchesSnapshot($response->json());
    }
}
