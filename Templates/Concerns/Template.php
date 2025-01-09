<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Templates\Concerns;

use App\Modules\Pagecraft\Components\Accordion;
use App\Modules\Pagecraft\Components\Activity;
use App\Modules\Pagecraft\Components\Button;
use App\Modules\Pagecraft\Components\CtaBlock;
use App\Modules\Pagecraft\Components\Divider;
use App\Modules\Pagecraft\Components\DividerHeading;
use App\Modules\Pagecraft\Components\Heading;
use App\Modules\Pagecraft\Components\Image;
use App\Modules\Pagecraft\Components\Pullout;
use App\Modules\Pagecraft\Components\Text;
use App\Modules\Pagecraft\Components\Video;
use ReflectionClass;

abstract class Template
{
    public bool $is_fixed = true;

    public function validComponents(): array
    {
        return [
            Accordion::class,
            Activity::class,
            Button::class,
            CtaBlock::class,
            Divider::class,
            DividerHeading::class,
            Heading::class,
            Image::class,
            Pullout::class,
            Text::class,
            Video::class,
        ];
    }

    public function getValidComponentsList(): array
    {
        $list = [];
        foreach ($this->validComponents() as $component) {
            $object = app($component);
            $list[] = [
                'type'     => $object->getType(),
                'name'     => $object->getName(),
                'variants' => $object->variants(),
                'config'   => $object->config(),
            ];
        }
        return $list;
    }

    public function getType(): string
    {
        $class = new ReflectionClass($this);
        return str($class->getShortName())->replace('Template', '')->camel()->toString();
    }

    public function getName(): string
    {
        return ucwords($this->getType());
    }

    public function validate(array $components): void
    {
    }

    public function getClass(): string
    {
        return static::class;
    }
}
