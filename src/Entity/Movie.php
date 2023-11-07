<?php

    namespace App\Entity;
    use Doctrine\Common\Collections\Collection;
    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\ORM\Mapping as ORM;

    /**
     * @ORM\Entity
     * @ORM\Table(name="movies")
     */
    class Movie{
        /**
         * @ORM\Id
         * @ORM\GeneratedValue(strategy="AUTO")
         * @ORM\Column(type="integer")
         */
        private int $id;
        /**
         * @ORM\Column(type="string")
         */
        private string $title;

        private string $image;
        
        private bool $video;
        private Collection $theme;
        private string $synopsis;
        private string $language;
        private bool $forAdult;
        private \DateTime $releaseDate;
        private float $note;
        private Collection $actors; //une collection fonctionne comme un tableau sous stéroïdes

        /**
         * @ORM\OneToMany(targetEntity="App\Entity\Avis", mappedBy="movie")
         */
        private $avis;

        public function addActor(Actor $actor):static{
            if(!$this->actors->contains($actor)){
                $this->actors->add($actor);
                // $actor->addMovie($this);
            }
            return $this;
        }
    
        public function removeACtor(Actor $actor):static{
            $this->actors->removeElement($actor);
            // $actor->removeMovie($this);
            return $this;
        }

        /**
         * @return Collection|Avis[]
         */
        public function getAvis(): Collection
        {
            return $this->avis;
        }

        public function addAvis(Avis $avis): self
        {
            if (!$this->avis->contains($avis)) {
                $this->avis[] = $avis;
                $avis->setMovie($this);
            }

            return $this;
        }

        public function removeAvis(Avis $avis): self
        {
            if ($this->avis->removeElement($avis)) {
                // set the owning side to null (unless already changed)
                if ($avis->getMovie() === $this) {
                    $avis->setMovie(null);
                }
            }

            return $this;
        }

        public function __construct(int $id=0, string $title="", string $image="", bool $video=false,  string $synopsis="", string $language="", bool $forAdult=false, ?\DateTime $releaseDate =null, float $note=0)
        {
            // ?\DateTime $releaseDate =null indique que le type peut être datetime et null
            $this->id = $id;
            $this->title = $title;
            $this->image = $image;
            $this->video = $video;
            $this->synopsis = $synopsis;
            $this->language = $language;
            $this->forAdult = $forAdult;
            $this->releaseDate = $releaseDate;
            $this->note = $note;

            $this->avis = new ArrayCollection();

            $this->actors = new ArrayCollection();

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

        public function getVideo():bool{
            return $this->video;
        }

        public function setVideo(bool $value): void{
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
    
	/**
	 * @return string
	 */
	public function getImage(): string {
		return $this->image;
	}
	
	/**
	 * @param string $image 
	 * @return self
	 */
	public function setImage(string $image): self {
		$this->image = $image;
		return $this;
	}

	/**
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getTheme():Collection {
		return $this->theme;
	}
	
	/**
	 * @param \Doctrine\Common\Collections\Collection $theme 
	 * @return self
	 */
	public function setTheme(Collection $theme): self {
		$this->theme = $theme;
		return $this;
	}

    public function getActors(): Collection {
        return $this->actors;
    }
    
    public function setActors(Collection $actors): self {
        $this->actors = $actors;
        return $this;
    }
    

}