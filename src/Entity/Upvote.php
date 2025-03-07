<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Post;
use App\Repository\UpvoteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    security: 'is_granted("ROLE_USER")',
    operations: [
        new Post(),
        new Delete(
            security: 'object.getOwnedBy() === user',
            securityPostDenormalize: 'object.getOwnedBy() === user'
        )
    ]
)]
#[ORM\Entity(repositoryClass: UpvoteRepository::class)]
#[ORM\UniqueConstraint(columns: ['feedback_id', 'owned_by_id'])]
class Upvote
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    #[Groups('user:read')]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'upvotes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('user:read')]
    private ?Feedback $feedback = null;

    #[ORM\ManyToOne(inversedBy: 'upvotes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $ownedBy = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFeedback(): ?Feedback
    {
        return $this->feedback;
    }

    public function setFeedback(?Feedback $feedback): static
    {
        $this->feedback = $feedback;

        return $this;
    }

    public function getOwnedBy(): ?User
    {
        return $this->ownedBy;
    }

    public function setOwnedBy(?User $ownedBy): static
    {
        $this->ownedBy = $ownedBy;

        return $this;
    }
}
