<?php

use App\Entity\Members;
use App\Entity\Person;
use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class MembersTeste extends KernelTestCase
{
    /**
     * @var Members
     */
    private $entity;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        $this->validator = static::$container->get(ValidatorInterface::class);

        $this->entity = new Members();
    }

    public function testNotEmployeeException(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->entity->setProject(new Project());
        $this->entity->setPerson(new Person());
    }

    public function testEmployeeValid(): void
    {
        $name = 'test';
        $person = new Person();
        $person->setEmployee(true);
        $person->setName($name);

        $this->entity->setProject(new Project());
        $this->entity->setPerson($person);

        self::assertEquals($name, $this->entity->getPerson()->getName());
    }
}