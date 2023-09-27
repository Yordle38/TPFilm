<?php

namespace App\Entity;

// use Doctrine\Comon\Collections\Collection;

class Theme{
    private int $id;
    private float $note;
    private string $comment;
    private string $language;
    private string $username;
    public function __construct(int $id,float $note,string $comment, string $language, string $username) {
        $this->id = $id;
        $this->note = $note;
        $this->comment = $comment;
        $this->language = $language;
        $this->username = $username;
    }

    
    // Getter pour $id
    public function getId(): int {
        return $this->id;
    }

    // Setter pour $id
    public function setId(int $id): void {
        $this->id = $id;
    }

    // Getter pour $note
    public function getNote(): float {
        return $this->note;
    }

    // Setter pour $note
    public function setNote(float $note): void {
        $this->note = $note;
    }

    // Getter pour $comment
    public function getComment(): string {
        return $this->comment;
    }

    // Setter pour $comment
    public function setComment(string $comment): void {
        $this->comment = $comment;
    }

    // Getter pour $language
    public function getLanguage(): string {
        return $this->language;
    }

    // Setter pour $language
    public function setLanguage(string $language): void {
        $this->language = $language;
    }

    // Getter pour $username
    public function getUsername(): string {
        return $this->username;
    }

    // Setter pour $username
    public function setUsername(string $username): void {
        $this->username = $username;
    }
}