<?php

namespace App\Modules\Pagecraft\Tests;

use App\Modules\Pagecraft\Pagecraft;
use Tests\TestCase;

class ComponentRegistrationTest extends TestCase
{
    /** @test */
    public function can_load_templates_and_components(): void
    {

        Pagecraft::load();
        $templates = Pagecraft::getTemplates();
        $this->assertIsArray($templates);
        $components = Pagecraft::getComponents();
        $this->assertIsArray($components);
    }
}
