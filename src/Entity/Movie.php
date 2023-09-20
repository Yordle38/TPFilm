<?php

    namespace App\Entity;

    class Movie{
        private int $id;

        private string $title;

        private string $image;

        private string $video;

        private \Doctrine\Common\Collections\Collection $theme;

        private string $synopsis;

        private string $language;

        private bool $forAdult;

        private \DateTime $releaseDate;

        private float $note;

        private string $producer;

        public function __construct(int $id, string $title, string $image, string $video,  string $synopsis, string $language, bool $forAdult, \DateTime $releaseDate, float $note, string $producer, \Doctrine\Common\Collections\Collection $theme)
        {
            $this->id = $id;
            $this->title = $title;
            $this->image = $image;
            $this->video = $video;
            $this->theme = $theme;
            $this->synopsis = $synopsis;
            $this->language = $language;
            $this->forAdult = $forAdult;
            $this->releaseDate = $releaseDate;
            $this->note = $note;
            $this->producer = $producer;
            $this->theme = $theme;
        }


        public function getId():int{
            return $this->id;
        }

        public function setId(int $value): void{
            $this->id=$value;
        }

        public function getTitle():string{
            return $this->title;
        }

        public function setTitle(string $value): void{
            $this->title=$value;
        }

        public function getVideo():string{
            return $this->video;
        }

        public function setVideo(string $value): void{
            $this->video=$value;
        }

        public function getSynopsis():string{
            return $this->synopsis;
        }

        public function setSynopsis(string $value): void{
            $this->synopsis=$value;
        }

        public function getLanguage():string{
            return $this->language;
        }

        public function setLanguage(string $value): void{
            $this->language=$value;
        }

        public function getForAdult(): bool{
            return $this->forAdult;
        }

        public function setForAdult(bool $value): void{
            $this->forAdult=$value;
        }

        public function getReleaseDate(): \Datetime{
            return $this->releaseDate;
        }

        public function setReleaseDate(\DateTime $value): void{
            $this->releaseDate=$value;
        }

        public function getNote(): float{
            return $this->note;
        }

        public function setNote(float $value): void{
            $this->note=$value;
        }

        public function getProducer(): string {
            return $this->producer;
        }

        public function setProducer(string $value): void{
            $this->producer=$value;
        }

    }