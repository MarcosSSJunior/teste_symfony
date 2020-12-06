<?php

declare(strict_types=1);    

namespace App\Entity;

use App\Repository\PersonRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="pessoa")
 * @ORM\Entity(repositoryClass=PersonRepository::class)
 */
class Person
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(name="nome", type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(name="datanascimento", type="date", nullable=true)
     */
    private $birthDate;

    /**
     * @ORM\Column(name="cpf", type="string", length=14, nullable=true)
     */
    private $document;

    /**
     * @ORM\Column(name="funcionario", type="boolean", nullable=true)
     */
    private $employee;

    public function getId(): ?int
    {
        return (int) $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getDocument(): ?string
    {
        return $this->document;
    }

    public function setDocument(?string $document): self
    {
        $this->document = $document;

        return $this;
    }

    public function getEmployee(): ?bool
    {
        return !!$this->employee;
    }

    public function setEmployee(?bool $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'birthDate' => $this->getBirthDate(),
            'document' => $this->getDocument(),
            'employee' => $this->getEmployee()
        ];
    }
}
