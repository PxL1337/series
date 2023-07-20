<?php

namespace App\Entity;

use App\Repository\SerieRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: SerieRepository::class)]
class Serie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Please provide a title for the serie !')]
    #[Assert\Length(max: 255)]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Assert\NotBlank(message: 'Please provide an overview for the serie !')]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $overview = null;

    #[Assert\Choice(choices: ['Cancelled', 'Returning', 'Ended'])]
    #[Assert\Length(max: 50)]
    #[ORM\Column(length: 50)]
    private ?string $status = null;

    #[Assert\NotBlank(message: 'Please provide a Note for the serie !')]
    #[Assert\Range(notInRangeMessage: 'You are not in range Dude !', min: 0, max: 10)]
    #[ORM\Column(type: Types::DECIMAL, precision: 3, scale: 1)]
    private ?string $vote = null;

    #[Assert\NotBlank(message: 'Please provide a Popularity Score for the serie !')]
    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2)]
    private ?string $popularity = null;

    #[Assert\NotBlank(message: 'Please provide a genre for the serie !')]
    #[Assert\Length(max: 255)]
    #[ORM\Column(length: 255)]
    private ?string $genres = null;

    #[Assert\NotBlank(message: 'Please provide a first air date for the serie !')]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $firstAirDate = null;

    #[Assert\GreaterThanOrEqual(propertyPath: 'firstAirDate',message: 'The last air date must be after the first air date')]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $lastAirDate = null;

    #[Assert\Length(max: 255)]
    #[ORM\Column(length: 255)]
    private ?string $backdrop = null;

    #[Assert\Length(max: 255)]
    #[ORM\Column(length: 255)]
    private ?string $poster = null;

    #[Assert\NotBlank(message: 'Please provide the tmdb ID for the serie !')]
    #[ORM\Column]
    private ?int $tmdbId = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreated = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateModified = null;

    private ?UploadedFile $posterFile = null;

    private ?UploadedFile $backdropFile = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getOverview(): ?string
    {
        return $this->overview;
    }

    public function setOverview(?string $overview): static
    {
        $this->overview = $overview;

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

    public function getVote(): ?string
    {
        return $this->vote;
    }

    public function setVote(string $vote): static
    {
        $this->vote = $vote;

        return $this;
    }

    public function getPopularity(): ?string
    {
        return $this->popularity;
    }

    public function setPopularity(string $popularity): static
    {
        $this->popularity = $popularity;

        return $this;
    }

    public function getGenres(): ?string
    {
        return $this->genres;
    }

    public function setGenres(string $genres): static
    {
        $this->genres = $genres;

        return $this;
    }

    public function getFirstAirDate(): ?\DateTimeInterface
    {
        return $this->firstAirDate;
    }

    public function setFirstAirDate(\DateTimeInterface $firstAirDate): static
    {
        $this->firstAirDate = $firstAirDate;

        return $this;
    }

    public function getLastAirDate(): ?\DateTimeInterface
    {
        return $this->lastAirDate;
    }

    public function setLastAirDate(\DateTimeInterface $lastAirDate): static
    {
        $this->lastAirDate = $lastAirDate;

        return $this;
    }

    public function getBackdrop(): ?string
    {
        return $this->backdrop;
    }

    public function setBackdrop(string $backdrop): static
    {
        $this->backdrop = $backdrop;

        return $this;
    }

    public function setBackdropFile(?UploadedFile $backdropFile = null): void
    {
        $this->backdropFile = $backdropFile;
    }

    public function getBackdropFile(): ?UploadedFile
    {
        return $this->backdropFile;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(string $poster): static
    {
        $this->poster = $poster;

        return $this;
    }

    public function setPosterFile(?UploadedFile $posterFile = null): void
    {
        $this->posterFile = $posterFile;
    }

    public function getPosterFile(): ?UploadedFile
    {
        return $this->posterFile;
    }

    public function getTmdbId(): ?int
    {
        return $this->tmdbId;
    }

    public function setTmdbId(int $tmdbId): static
    {
        $this->tmdbId = $tmdbId;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): static
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateModified(): ?\DateTimeInterface
    {
        return $this->dateModified;
    }

    public function setDateModified(?\DateTimeInterface $dateModified): static
    {
        $this->dateModified = $dateModified;

        return $this;
    }
}
