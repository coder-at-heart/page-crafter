<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Components\Concerns;

use ReflectionClass;

abstract class Component
{
    public function rules(): array
    {
        return [];
    }

    public function errorMessages(): array
    {
        return [];
    }

    public function default(): array
    {
        return [];
    }

    public function getType(): string
    {
        $class = new ReflectionClass($this);
        return str($class->getShortName())->camel()->toString();
    }

    public function getName(): string
    {
        $class     = new ReflectionClass($this);
        $shortName = $class->getShortName();

        return ucwords(str_replace(['-', '_'], ' ', preg_replace('/([a-z])([A-Z])/', '$1 $2', $shortName)));
    }

    public function variants(): array
    {
        return [];
    }

    public function config(): array
    {
        return [];
    }

    public function hasVariants(): bool
    {
        return count($this->variants()) > 0;
    }

    public function content(array $content): array
    {
        return [
            "type"    => $content['type'],
            "variant" => $content['variant'],
            "data"    => $content['data'],
        ];
    }
}
