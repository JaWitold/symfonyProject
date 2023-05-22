<?php

declare(strict_types=1);

namespace App\Model;

use App\Enum\HealthStatus;
use OpenApi\Attributes as OA;
use Symfony\Component\Uid\Uuid;

#[OA\Schema(title: 'Health', description: 'App health status')]
readonly class Health
{
    #[OA\Property(type: 'string', format: 'uuid')]
    public Uuid $flowId;

    public function __construct(#[OA\Property] public HealthStatus $status = HealthStatus::OK)
    {
        $this->flowId = Uuid::v4();
    }
}
