<?php

declare(strict_types=1);

namespace App\Service;

use App\Model\Health;

class HealthService
{
    public function __invoke(): Health
    {
        return new Health();
    }
}
