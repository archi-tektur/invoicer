<?php

declare(strict_types=1);

namespace App\User\Application\Query;

use App\User\Infrastructure\Doctrine\Repository\UserWriteModel;
use Symfony\Component\Uid\Uuid;

final class GetCurrentUserQuery
{
    private UserWriteModel $writeModel;

    public function __construct(UserWriteModel $writeModel)
    {
        $this->writeModel = $writeModel;
    }

    public function __invoke(Uuid $id)
    {
        $id = Uuid::fromString('6848fe0d-1a44-4ed8-a3a0-14788ed35511');
        $this->writeModel->get($id);
    }
}
