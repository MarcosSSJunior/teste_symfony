<?php

use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ProjectTeste extends KernelTestCase
{
    /**
     * @var Project
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

        $this->entity = new Project();
    }

    public function testInvalidRisk(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->entity->setRisk('risk invalid');
    }

    public function testInvalidStatus(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->entity->setStatus('status invalid');
    }

    public function testValidProject(): void
    {
        $this->entity->setRisk(Project::RISK_HIGH);
        $this->entity->setStatus(Project::STATUS_CLOSED);
        $this->entity->setDescription('test');

        self::assertEquals($this->entity->getStatus(), Project::STATUS_CLOSED);
    }


}