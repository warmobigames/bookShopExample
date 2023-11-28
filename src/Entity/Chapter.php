<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ChapterRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ChapterRepository::class)]
#[ApiResource]
class Chapter
{
    const CHAPTER_STATUS_DRAFT = 'DRAFT';
    const CHAPTER_STATUS_PUBLISHED = 'PUBLISHED';
    const CHAPTER_STATUSES = [
        self::CHAPTER_STATUS_DRAFT,
        self::CHAPTER_STATUS_PUBLISHED,
    ];
    #[Groups([
        'book:read'
    ])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Book $book;

    #[Groups([
        'book:read'
    ])]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Groups([
        'book:read'
    ])]
    #[Assert\Choice(choices: self::CHAPTER_STATUSES)]
    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[Groups([
        'book:read'
    ])]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[Groups([
        'book:read'
    ])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentBefore = null;

    #[Groups([
        'book:read'
    ])]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentAfter = null;

    #[Groups([
        'book:read'
    ])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Timestampable(on: 'create')]
    private ?\DatetimeInterface $createdAt;

    #[Groups([
        'book:read'
    ])]
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Timestampable(on: 'update')]
    private ?\DatetimeInterface $updatedAt;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getCommentBefore(): ?string
    {
        return $this->commentBefore;
    }

    public function setCommentBefore(string $commentBefore): static
    {
        $this->commentBefore = $commentBefore;

        return $this;
    }

    public function getCommentAfter(): ?string
    {
        return $this->commentAfter;
    }

    public function setCommentAfter(string $commentAfter): static
    {
        $this->commentAfter = $commentAfter;

        return $this;
    }

    /**
     * @return Book|null
     */
    public function getBook(): ?Book
    {
        return $this->book;
    }

    /**
     * @param Book|null $book
     */
    public function setBook(?Book $book): void
    {
        $this->book = $book;
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
}
