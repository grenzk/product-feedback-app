<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\FeedbackRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeedbackRepository::class)]
#[ApiResource]
class Feedback
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $detail = null;

    #[ORM\Column(enumType: FeedbackCategoryEnum::class)]
    private ?FeedbackCategoryEnum $category = null;

    #[ORM\Column(enumType: FeedbackStatusEnum::class)]
    private ?FeedbackStatusEnum $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(string $detail): static
    {
        $this->detail = $detail;

        return $this;
    }

    public function getCategory(): ?FeedbackCategoryEnum
    {
        return $this->category;
    }

    public function setCategory(FeedbackCategoryEnum $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getStatus(): ?FeedbackStatusEnum
    {
        return $this->status;
    }

    public function setStatus(FeedbackStatusEnum $status): static
    {
        $this->status = $status;

        return $this;
    }
}
