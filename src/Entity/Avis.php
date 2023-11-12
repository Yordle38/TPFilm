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
     * @ORM\Column(type="integer")
    */
    private $idmovie;
    
    private string $username;
    public function __construct(int $id=0,float $note=0,string $comment="", string $language="", string $username="", $idmovie = 0) {
        $this->id = $id;
        $this->note = $note;
        $this->comment = $comment;
        $this->language = $language;
        $this->username = $username;
        $this->idmovie = $idmovie;

    }

    public function getIdmovie(): ?int
    {
        return $this->idmovie;
    }

    public function setIdmovie(int $idmovie): self
    {
        $this->idmovie = $idmovie;

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