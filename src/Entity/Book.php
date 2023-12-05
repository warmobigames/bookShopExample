<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\Action\GetBookAction;
use App\Filter\BookByGenreFilter;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['book:read']],
    denormalizationContext: ['groups' => ['book:write']]
)]
#[Get(controller: GetBookAction::class)]
#[GetCollection(
    normalizationContext: ['groups' => ['book:readAll']]
)]
#[Patch(security: 'object.getUser() === user or is_granted("ROLE_ADMIN")')]
#[Put]
#[Post(security: 'is_granted("ROLE_USER")')]

#[ApiFilter(
    SearchFilter::class,
    properties: [
        'user' => 'exact'
    ]
)]
class Book
{
    const BOOK_STATUS_DRAFT = 'DRAFT';
    const BOOK_STATUS_PUBLISHED = 'PUBLISHED';
    const BOOK_STATUS_STOPPED = 'STOPPED';
    const BOOK_STATUS_FINISHED = 'FINISHED';
    const BOOK_STATUSES = [
        self::BOOK_STATUS_DRAFT,
        self::BOOK_STATUS_PUBLISHED,
        self::BOOK_STATUS_STOPPED,
        self::BOOK_STATUS_FINISHED,
    ];

    const BOOK_AGE_RESTRICTION_CHILDREN = 0;
    const BOOK_AGE_RESTRICTION_ADULTS = 18;
    const BOOK_AGE_RESTRICTIONS = [
        self::BOOK_AGE_RESTRICTION_CHILDREN,
        self::BOOK_AGE_RESTRICTION_ADULTS,
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'book:read',
        'book:readAll',
    ])]
    private ?int $id = null;

    #[Groups([
        'book:read',
    ])]
    #[ORM\ManyToOne]
    private ?User $user = null;

    #[Groups([
        'book:read',
        'book:write',
        'book:readAll',
    ])]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Groups([
        'book:read',
        'book:write',
        'book:readAll',
    ])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[Groups([
        'book:read',
        'book:write',
        'book:readAll',
    ])]
    #[Assert\Choice(choices: self::BOOK_STATUSES)]
    #[ORM\Column]
    private ?string $status = null;

    #[Groups([
        'book:read',
        'book:write',
        'book:readAll',
    ])]
    #[Assert\Choice(choices: self::BOOK_AGE_RESTRICTIONS)]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $ageRestriction = null;

    #[Groups([
        'book:read',
    ])]
    #[ORM\OneToMany(mappedBy: 'book', targetEntity: Chapter::class)]
    private ?Collection $chapters;

    #[Groups([
        'book:read',
        'book:readAll',
    ])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Timestampable(on: 'create')]
    private ?\DatetimeInterface $createdAt;

    #[Groups([
        'book:read',
        'book:readAll',
    ])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Timestampable(on: 'update')]
    private ?\DatetimeInterface $updatedAt;

    #[Groups([
        'book:read',
        'book:readAll',
        'book:write',
    ])]
    #[ApiFilter(BookByGenreFilter::class)]
    #[ORM\ManyToMany(targetEntity: Genre::class, mappedBy: 'books')]
    private Collection $genres;

    public function __construct()
    {
        $this->genres = new ArrayCollection();
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

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int|null
     */
    public function getAgeRestriction(): ?int
    {
        return $this->ageRestriction;
    }

    /**
     * @param int|null $ageRestriction
     */
    public function setAgeRestriction(?int $ageRestriction): void
    {
        $this->ageRestriction = $ageRestriction;
    }

    /**
     * @return \DatetimeInterface|null
     */
    public function getCreatedAt(): ?\DatetimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return \DatetimeInterface|null
     */
    public function getUpdatedAt(): ?\DatetimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @return Collection|null
     */
    public function getChapters(): ?Collection
    {
        return $this->chapters;
    }

    public function addChapter(Chapter $chapter): static
    {
        if (!$this->chapters->contains($chapter)) {
            $this->chapters->add($chapter);
            $chapter->setBook($this);
        }

        return $this;
    }

    public function removeChapter(Chapter $chapter): static
    {
        if ($this->chapters->removeElement($chapter)) {
            if ($chapter->getBook() == $this) {
                $chapter->setBook(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getTitle();
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre): static
    {
        if (!$this->genres->contains($genre)) {
            $this->genres->add($genre);
            $genre->addBook($this);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): static
    {
        if ($this->genres->removeElement($genre)) {
            $genre->removeBook($this);
        }

        return $this;
    }
}
