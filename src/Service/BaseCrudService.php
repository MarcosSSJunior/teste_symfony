<?php

namespace App\Service;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class BaseCrudService
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var ServiceEntityRepository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $entityName;

    public function __construct(
        EntityManagerInterface $entityManager,
        ServiceEntityRepository $repository,
        string $entityName
    ) {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
        $this->entityName = $entityName;
    }

    public function show(int $id): array
    {
        $entity = $this->repository->find($id);
        if ($entity === null) {
            throw new NotFoundHttpException('Entity not found.');
        }
        return $entity->toArray();
    }

    public function list(int $page, int $size): array
    {
        $entities = $this->repository->findBy([], [], $size, $page);
        return array_map(function($entity) {
            return $entity->toArray();
        }, $entities);
    }

    public function create(array $data): array
    {
        $entity = new $this->entityName();
        $this->populateEntity($entity, $data);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        return $entity->toArray();
    }

    public function update(int $id, array $data): array
    {
        $entity = $this->repository->find($id);
        $this->populateEntity($entity, $data);
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        return $entity->toArray();
    }

    public function delete(int $id): void
    {
        $entity = $this->repository->find($id);
        if ($entity === null) {
            throw new NotFoundHttpException('Entity not found.');
        }
        $this->deletableEntity($entity);
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    private function populateEntity($entity, array $data): void
    {
        $metadata = $this->entityManager->getClassMetadata($this->entityName);
        foreach ($data as $property => $value) {
            if(!empty($value) && $metadata->hasAssociation($property)) {
                $map = $metadata->getAssociationMapping($property);
                $value = $this->entityManager->getRepository($map['targetEntity'])->find($value);
                if(empty($value)){
                    throw new NotFoundHttpException(ucfirst($map['fieldName']) . ' not found.');
                }
            }

            $setter = 'set' . ucfirst($property);
            try {
                $entity->$setter($value);
            } catch (InvalidArgumentException $ex) {
                throw new UnprocessableEntityHttpException($ex->getMessage());
            } catch (\Exception $ex) {
                throw $ex;
            }
        }
    }

    protected function deletableEntity($entity): void
    {
    }
}
