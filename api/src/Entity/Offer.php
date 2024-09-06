<?php

namespace App\Entity;

use App\Repository\OfferRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OfferRepository::class)]
class Offer
{
    public const STATUS_PENDING = 'status_pending';
    public const STATUS_ACCEPTED = 'status_accepted';
    public const STATUS_REJECTED = 'status_rejected';

    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['offer:view', 'room:view-list', 'job:view'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'offers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Job $job = null;

    #[ORM\ManyToOne(inversedBy: 'offers')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['offer:view', 'job:view'])]
    private ?User $jobber = null;

    #[ORM\Column]
    #[Groups(['offer:view', 'job:view'])]
    private ?float $amount = null;

    #[ORM\Column(length: 255)]
    #[Groups(['offer:view', 'job:view'])]
    private ?string $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJob(): ?Job
    {
        return $this->job;
    }

    public function setJob(?Job $job): static
    {
        $this->job = $job;

        return $this;
    }

    public function getJobber(): ?User
    {
        return $this->jobber;
    }

    public function setJobber(?User $jobber): static
    {
        $this->jobber = $jobber;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }
}
