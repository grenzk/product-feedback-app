<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use App\Repository\FeedbackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FeedbackRepository::class)]
#[ApiResource(
    security: 'is_granted("ROLE_USER")',
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Patch(
            security: 'object.getOwnedBy() === user',
            securityPostDenormalize: 'object.getOwnedBy() === user',
        ),
        new Delete(
            security: 'object.getOwnedBy() === user',
            securityPostDenormalize: 'object.getOwnedBy() === user',
        )
    ],
    normalizationContext: ['groups' => ['feedback']]
)]
#[Groups('feedback')]
class Feedback
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 50)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank]
    private ?string $detail = null;

    #[ORM\Column(enumType: FeedbackCategoryEnum::class)]
    #[Assert\NotBlank]
    #[Assert\Type(type: FeedbackCategoryEnum::class)]
    private ?FeedbackCategoryEnum $category = null;

    #[ORM\Column(enumType: FeedbackStatusEnum::class)]
    #[Assert\NotBlank]
    #[Assert\Type(type: FeedbackStatusEnum::class)]
    private ?FeedbackStatusEnum $status = null;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'feedback', orphanRemoval: true, cascade: ['persist'])]
    private Collection $comments;

    #[ORM\ManyToOne(inversedBy: 'feedback')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $ownedBy = null;

    /**
     * @var Collection<int, Upvote>
     */
    #[ORM\OneToMany(targetEntity: Upvote::class, mappedBy: 'feedback', orphanRemoval: true)]
    private Collection $upvotes;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->upvotes = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments->filter(function (Comment $comment) {
            return $comment->getParentComment() === null;
        });
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setFeedback($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getFeedback() === $this) {
                $comment->setFeedback(null);
            }
        }

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

    /**
     * @return Collection<int, Upvote>
     */
    public function getUpvotes(): Collection
    {
        return $this->upvotes;
    }

    public function addUpvote(Upvote $upvote): static
    {
        if (!$this->upvotes->contains($upvote)) {
            $this->upvotes->add($upvote);
            $upvote->setFeedback($this);
        }

        return $this;
    }

    public function removeUpvote(Upvote $upvote): static
    {
        if ($this->upvotes->removeElement($upvote)) {
            // set the owning side to null (unless already changed)
            if ($upvote->getFeedback() === $this) {
                $upvote->setFeedback(null);
            }
        }

        return $this;
    }

    #[Groups('feedback')]
    #[SerializedName('upvotes')]
    public function getUpvoteCount(): int
    {
        return $this->upvotes->count();
    }
}
