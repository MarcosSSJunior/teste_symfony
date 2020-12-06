<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

/**
 * @ORM\Table(name="projeto")
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 */
class Project
{
    const STATUS_UNDER_ANALYSIS = 'em análise';
    const STATUS_ANALYSED = 'análise realizada';
    const STATUS_ANALYSIS_APPROVED = 'análise aprovada';
    const STATUS_STARTED = 'iniciado';
    const STATUS_PLANNED = 'planejado';
    const STATUS_IN_PROGRESS = 'em andamento';
    const STATUS_CLOSED = 'encerrado';
    const STATUS_CANCELLED = 'cancelado';

    const RISK_LOW = 'baixo risco';
    const RISK_MEDIUM = 'médio risco';
    const RISK_HIGH = 'alto risco';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(name="nome", type="string", length=200)
     */
    private $name;

    /**
     * @ORM\Column(name="data_inicio", type="date", nullable=true)
     */
    private $begginingDate;

    /**
     * @ORM\Column(name="data_previsao_fim", type="date", nullable=true)
     */
    private $previsionEndDate;

    /**
     * @ORM\Column(name="data_fim", type="date", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(name="descricao", type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(name="status", type="string", length=45, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(name="orcamento", type="float", nullable=true)
     */
    private $budget;

    /**
     * @ORM\Column(name="risco", type="string", length=45, nullable=true)
     */
    private $risk;

    /**
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(name="idgerente", referencedColumnName="id", nullable=false)
     */
    private $manager;

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

    public function getBegginingDate(): ?\DateTimeInterface
    {
        return $this->begginingDate;
    }

    public function setBegginingDate(?\DateTimeInterface $begginingDate): self
    {
        $this->begginingDate = $begginingDate;

        return $this;
    }

    public function getPrevisionEndDate(): ?\DateTimeInterface
    {
        return $this->previsionEndDate;
    }

    public function setPrevisionEndDate(?\DateTimeInterface $previsionEndDate): self
    {
        $this->previsionEndDate = $previsionEndDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        if (!in_array($status, [
            self::STATUS_UNDER_ANALYSIS,
            self::STATUS_ANALYSED,
            self::STATUS_ANALYSIS_APPROVED,
            self::STATUS_STARTED,
            self::STATUS_PLANNED,
            self::STATUS_IN_PROGRESS,
            self::STATUS_CLOSED,
            self::STATUS_CANCELLED])) {
            throw new InvalidArgumentException('Status invalid.');
        }
        $this->status = $status;

        return $this;
    }

    public function getBudget(): ?float
    {
        return $this->budget;
    }

    public function setBudget(?float $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    public function getRisk(): ?string
    {
        return $this->risk;
    }

    public function setRisk(?string $risk): self
    {
        if (!in_array($risk, [
            self::RISK_LOW,
            self::RISK_MEDIUM,
            self::RISK_HIGH])) {
            throw new InvalidArgumentException('Risk invalid.');
        }
        $this->risk = $risk;

        return $this;
    }

    public function getManager(): ?Person
    {
        return $this->manager;
    }

    public function setManager(?Person $manager): self
    {
        $this->manager = $manager;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'begginingDate' => $this->getBegginingDate(),
            'previsionEndDate' => $this->getPrevisionEndDate(),
            'endDate' => $this->getEndDate(),
            'description'=> $this->getDescription(),
            'status' => $this->getStatus(),
            'budget' => $this->getBudget(),
            'risk' => $this->getRisk(),
            'manager' => [
                $this->getManager()->toArray()
            ]
        ];
    }
}
