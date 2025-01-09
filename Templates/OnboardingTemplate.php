<?php

declare(strict_types=1);

namespace App\Modules\Pagecraft\Templates;

use App\Modules\Pagecraft\Components\Onboarding;
use App\Modules\Pagecraft\Templates\Concerns\Template;

class OnboardingTemplate extends Template
{
    public function validComponents(): array
    {
        return [
            Onboarding::class,
        ];
    }
}
