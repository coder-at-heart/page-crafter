<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft;

use App\Modules\Pagecraft\Components\Concerns\Component;
use App\Modules\Pagecraft\Enums\PageStatus;
use App\Modules\Pagecraft\Events\PagecraftLoadComponentsEvent;
use App\Modules\Pagecraft\Events\PagecraftLoadTemplateEvent;
use App\Modules\Pagecraft\Models\Page;
use App\Modules\Pagecraft\Templates\Concerns\Template;

class Pagecraft
{
    /**
     * @var Template[]
     */
    protected static array $templates = [];

    /**
     * @var Component[]
     */
    protected static array $components = [];

    public static function load(): void
    {
        event(new PagecraftLoadComponentsEvent());
        event(new PagecraftLoadTemplateEvent());
    }

    public static function registerTemplate(string $class): void
    {
        /** @var Template $template */
        $template                              = app($class);
        self::$templates[$template->getType()] = $template;
    }

    public static function registerComponent(string $class): void
    {
        /** @var Component $component */
        $component                               = app($class);
        self::$components[$component->getType()] = $component;
    }

    public static function createAllFixedPages(): void
    {
        foreach (self::$templates as $template) {
            if (! $template->is_fixed) {
                continue;
            }

            if (Page::whereSlug($template->getType())->count() > 0) {
                continue;
            }

            $content = [];
            foreach ($template->validComponents() as $component) {
                /** @var Component $component */
                $component = app($component);
                $content[] = [
                    'type'    => $component->getType(),
                    'variant' => $component->hasVariants() ? array_key_first($component->variants()) : '',
                    'data'    => $component->default(),
                ];
            }

            Page::create([
                'slug'     => $template->getType(),
                'template' => $template->getType(),
                'title'    => "The ".$template->getType()." page",
                'admin_id' => request()->user()->id,
                'status'   => PageStatus::PUBLISHED,
                'content'  => $content,
            ]);
        }
    }

    public static function isComponentRegistered(string $name): bool
    {
        return isset(self::$components[$name]);
    }

    public static function isTemplateRegistered(string $name): bool
    {
        return isset(self::$templates[$name]);
    }

    public static function getTemplates(): array
    {
        return self::$templates;
    }

    public static function getTemplate(string $template): ?Template
    {
        return self::$templates[$template] ?? null;
    }

    public static function getComponents(): array
    {
        return self::$components;
    }

    public static function getComponent(string $component): ?Component
    {
        return self::$components[$component] ?? null;
    }

    public static function routes(): array
    {
        return [
            'messages'  => '/messages',
            'dashboard' => '/',
            'guides'    => '/guides',
            'itinerary' => '/itinerary',
        ];
    }

    public static function icons(): array
    {
        return [
            'calendar',
            'camera',
            'chat',
            'chevron-down',
            'chevron-left',
            'chevron-right',
            'close',
            'create',
            'dining',
            'envelope',
            'location',
            'menu',
            'minus',
            'moon',
            'notifications',
            'overflow',
            'paper-aeroplane',
            'photo',
            'play',
            'plus',
            'question',
            'reply',
            'sun',
            'sunrise',
            'user',
            'warning',
            'zs',
        ];
    }
}
