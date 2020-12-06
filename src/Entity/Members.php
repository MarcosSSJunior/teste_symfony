<?php

namespace App\Entity;

use App\Repository\MembersRepository;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

/**
 * @ORM\Table(name="membros")
 * @ORM\Entity(repositoryClass=MembersRepository::class)
 */
class Members
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Project")
     * @ORM\JoinColumn(name="idprojeto", referencedColumnName="id", nullable=false)
     */
    private $project;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="idpessoa", referencedColumnName="id", nullable=false)
     */
    private $person;

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(Person $person): self
    {
        if (!$person->getEmployee()) {
            throw new InvalidArgumentException('Only employees are able to be a member of a project');
        }
        $this->person = $person;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'project' => $this->getProject()->toArray(),
            'person' => $this->getPerson()->toArray()
        ];
    }
}
