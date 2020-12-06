<?php

use App\Entity\Person;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class PersonTeste extends KernelTestCase
{
    /**
     * @var Person
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

        $this->entity = new Person();
    }

    public function testValidPerson(): void
    {
        $name = 'test';
        $this->entity->setName($name);
        self::assertEquals($this->entity->getName(), $name);
    }
}