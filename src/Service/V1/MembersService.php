<?php

namespace App\Service\V1;

use App\Entity\Members;
use App\Repository\MembersRepository;
use App\Service\BaseCrudService;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class MembersService extends BaseCrudService
{
    public function __construct(
        EntityManagerInterface $entityManager,
        MembersRepository $repository
    ) {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
        parent::__construct(
            $entityManager,
            $repository, 
            Members::class
        );
    }

    public function listByProjects(int $projectId)
    {
        $entities = $this->repository->findBy([
            'project' => $projectId
        ]);
        return array_map(function(Members $entity) {
            return $entity->getPerson()->toArray();
        }, $entities);
    }

    public function createProject(int $projectId, array $data)
    {
        $data['project'] = [
            'id' => $projectId
        ];
        try {
            return parent::create($data);
        } catch (UniqueConstraintViolationException $ex) {
            throw new UnprocessableEntityHttpException('Member already registered.');
        } catch (\Exception $e) {
            throw $e;
        }
        
    }

    public function deleteProject(int $projectId, int $personId): void
    {
        $entity = $this->repository->findOneBy([
            'project' => $projectId,
            'person' => $personId
        ]);

        if ($entity === null) {
            throw new NotFoundHttpException('Member not found.');
        }

        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }
}
