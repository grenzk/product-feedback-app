<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use App\Repository\UserRepository;
use App\State\UserPasswordHasher;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    security: 'is_granted("ROLE_USER")',
    operations: [
        new Post(
            security: 'is_granted("PUBLIC_ACCESS")',
            processor: UserPasswordHasher::class,
            validationContext: ['groups' => ['Default', 'user:create']]
        ),
        new Get()
    ],
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:create']]
)]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['username', 'email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    #[Groups(['user:read', 'user:create'])]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3)]
    private ?string $username = null;

    #[ORM\Column(length: 50, unique: true)]
    #[Groups(['user:read', 'user:create'])]
    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $email = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[Groups(['user:create'])]
    #[Assert\NotBlank(groups: ['user:create'])]
    #[Assert\Length(min: 6)]
    private ?string $plainPassword = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var Collection<int, Feedback>
     */
    #[ORM\OneToMany(targetEntity: Feedback::class, mappedBy: 'ownedBy', orphanRemoval: true)]
    private Collection $feedback;

    public function __construct()
    {
        $this->feedback = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): static
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Feedback>
     */
    public function getFeedback(): Collection
    {
        return $this->feedback;
    }

    public function addFeedback(Feedback $feedback): static
    {
        if (!$this->feedback->contains($feedback)) {
            $this->feedback->add($feedback);
            $feedback->setOwnedBy($this);
        }

        return $this;
    }

    public function removeFeedback(Feedback $feedback): static
    {
        if ($this->feedback->removeElement($feedback)) {
            // set the owning side to null (unless already changed)
            if ($feedback->getOwnedBy() === $this) {
                $feedback->setOwnedBy(null);
            }
        }

        return $this;
    }
}
