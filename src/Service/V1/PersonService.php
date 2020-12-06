<?php

namespace App\Service\V1;

use App\Entity\Person;
use App\Repository\PersonRepository;
use App\Service\BaseCrudService;
use Doctrine\ORM\EntityManagerInterface;

class PersonService extends BaseCrudService
{

    public function __construct(
        EntityManagerInterface $entityManager,
        PersonRepository $repository
    ) {
        parent::__construct(
            $entityManager,
            $repository, 
            Person::class
        );
    }
    
}
