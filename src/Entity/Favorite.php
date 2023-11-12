<?php

namespace App\Entity;

use App\Repository\FavoriteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriteRepository::class)]
class Favorite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $id_serie = null;

    #[ORM\Column(nullable: true)]
    private ?int $id_movie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdSerie(): ?int
    {
        return $this->id_serie;
    }

    public function setIdSerie(?int $id_serie): static
    {
        $this->id_serie = $id_serie;

        return $this;
    }

    public function getIdMovie(): ?int
    {
        return $this->id_movie;
    }

    public function setIdMovie(?int $id_movie): static
    {
        $this->id_movie = $id_movie;

        return $this;
    }
}
