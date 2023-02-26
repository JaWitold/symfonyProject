<?php

declare(strict_types=1);

namespace App\Model;

use App\Enum\HealthStatus;
use Symfony\Component\Uid\Uuid;

readonly class Health
{
    public Uuid $flowId;

    public function __construct(public HealthStatus $status = HealthStatus::OK)
    {
        $this->flowId = Uuid::v4();
    }
}
