<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Providers;

use App\Modules\Pagecraft\Components\Accordion;
use App\Modules\Pagecraft\Components\Activity;
use App\Modules\Pagecraft\Components\Button;
use App\Modules\Pagecraft\Components\CtaBlock;
use App\Modules\Pagecraft\Components\Divider;
use App\Modules\Pagecraft\Components\DividerHeading;
use App\Modules\Pagecraft\Components\Heading;
use App\Modules\Pagecraft\Components\Image;
use App\Modules\Pagecraft\Components\Onboarding;
use App\Modules\Pagecraft\Components\Pullout;
use App\Modules\Pagecraft\Components\Text;
use App\Modules\Pagecraft\Components\Video;
use App\Modules\Pagecraft\Events\PagecraftLoadComponentsEvent;
use App\Modules\Pagecraft\Events\PagecraftLoadTemplateEvent;
use App\Modules\Pagecraft\Pagecraft;
use App\Modules\Pagecraft\Templates\CustomTemplate;
use App\Modules\Pagecraft\Templates\DashboardTemplate;
use App\Modules\Pagecraft\Templates\OnboardingTemplate;
use Caffeinated\Modules\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class TemplateServiceProvider extends ServiceProvider
{
    /**
     * Register the templates and components
     */
    public function register(): void
    {
        // Register components first
        Event::listen(PagecraftLoadComponentsEvent::class, function (): void {
            Pagecraft::registerComponent(Accordion::class);
            Pagecraft::registerComponent(Activity::class);
            Pagecraft::registerComponent(Button::class);
            Pagecraft::registerComponent(CtaBlock::class);
            Pagecraft::registerComponent(Divider::class);
            Pagecraft::registerComponent(DividerHeading::class);
            Pagecraft::registerComponent(Heading::class);
            Pagecraft::registerComponent(Image::class);
            Pagecraft::registerComponent(Onboarding::class);
            Pagecraft::registerComponent(Pullout::class);
            Pagecraft::registerComponent(Text::class);
            Pagecraft::registerComponent(Video::class);
        });

        Event::listen(PagecraftLoadTemplateEvent::class, function (): void {
            Pagecraft::registerTemplate(CustomTemplate::class);
            Pagecraft::registerTemplate(DashboardTemplate::class);
            Pagecraft::registerTemplate(OnboardingTemplate::class);
        });
    }
}
