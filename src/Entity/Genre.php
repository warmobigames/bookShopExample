<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Repository\GenreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GenreRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['genre:read']],
    denormalizationContext: ['groups' => ['genre:write']]
)]
#[Post(security: 'is_granted("ROLE_ADMIN")')]
class Genre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'genre:read',
        'book:read',
        'book:readAll',
    ])]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Book::class, inversedBy: 'genres')]
    private Collection $books;

    #[Groups([
        'genre:read',
        'genre:write',
        'book:read',
        'book:readAll',
    ])]
    #[ORM\Column(length: 50)]
    private ?string $title = null;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): static
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
        }

        return $this;
    }

    public function removeBook(Book $book): static
    {
        $this->books->removeElement($book);

        return $this;
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
}
