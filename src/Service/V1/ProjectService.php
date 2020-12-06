<?php

namespace App\Service\V1;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use App\Service\BaseCrudService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ProjectService extends BaseCrudService
{

    public function __construct(
        EntityManagerInterface $entityManager,
        ProjectRepository $repository
    ) {
        parent::__construct(
            $entityManager,
            $repository, 
            Project::class
        );
    }

    protected function deletableEntity($entity): void
    {
        if (in_array($entity->getStatus(), [
            Project::STATUS_STARTED,
            Project::STATUS_IN_PROGRESS,
            Project::STATUS_CLOSED
        ])) {
            throw new UnprocessableEntityHttpException('Deletion not permitted in current status.');
        }
    }
}
