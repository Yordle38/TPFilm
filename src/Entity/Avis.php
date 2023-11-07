<?php

namespace App\Entity;

// use Doctrine\Comon\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="avis")
 */
class Avis{
     /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
    */
    private $note;
        /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
    */
    private string $language;

    /**
     * @ORM\Column(type="string", length=255)
    */

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Movie", inversedBy="avis")
     * @ORM\JoinColumn(name="movie_id", referencedColumnName="id")
     */
    private $movie;
    private string $username;
    public function __construct(int $id=0,float $note=0,string $comment="", string $language="", string $username="") {
        $this->id = $id;
        $this->note = $note;
        $this->comment = $comment;
        $this->language = $language;
        $this->username = $username;
    }

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(?Movie $movie): self
    {
        $this->movie = $movie;

        return $this;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getNote(): float {
        return $this->note;
    }

    public function setNote(float $note): void {
        $this->note = $note;
    }

    public function getComment(): string {
        return $this->comment;
    }

    public function setComment(string $comment): void {
        $this->comment = $comment;
    }

    public function getLanguage(): string {
        return $this->language;
    }

    public function setLanguage(string $language): void {
        $this->language = $language;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function setUsername(string $username): void {
        $this->username = $username;
    }
}