<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BookRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ApiResource]
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
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[Assert\Choice(choices: self::BOOK_STATUSES)]
    #[ORM\Column]
    private ?string $status = null;

    #[Assert\Choice(choices: self::BOOK_AGE_RESTRICTIONS)]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $ageRestriction = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Timestampable(on: 'create')]
    private ?\DatetimeInterface $createdAt;

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
}
