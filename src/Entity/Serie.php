<?php 

namespace App\Entity;
class Serie {
    private int $id;
    private string $name;
    private int $nbSeasons;
    private string $language;
    private string $country;

    public function __construct(int $id,string $name,int $nbSeasons, string $language, string $country) {
        $this->id = $id;
        $this->name = $name;
        $this->nbSeasons = $nbSeasons;
        $this->language = $language;
        $this->country = $country;
    }

    // Getter pour id
    public function getId(): int {
        return $this->id;
    }

    // Setter pour id
    public function setId(int $id): void {
        $this->id = $id;
    }

    // Getter pour name
    public function getName(): string {
        return $this->name;
    }

    // Setter pour name
    public function setName(string $name): void {
        $this->name = $name;
    }

    // Getter pour nbSeasons
    public function getNbSeasons(): int {
        return $this->nbSeasons;
    }

    // Setter pour nbSeasons
    public function setNbSeasons(int $nbSeasons): void {
        $this->nbSeasons = $nbSeasons;
    }

    // Getter pour language
    public function getLanguage():string {
        return $this->language;
    }

    // Setter pour language
    public function setLanguage(string $language):void {
        $this->language = $language;
    }

    // Getter pour country
    public function getCountry(): string {
        return $this->country;
    }

    // Setter pour country
    public function setCountry(string $country): void {
        $this->country = $country;
    }
}