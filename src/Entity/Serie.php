<?php 

namespace App\Entity;
class Serie {
    private int $id;
    private string $name;
    private int $nbSeasons;
    private string $language;
    private int $nbEpisodes;
    private int $nbNotes;
    private string $country;
    private string $image;
    private string $producer;
    private \DateTime $releaseDate;
    private bool $forAdult;
    private string $status;



    public function __construct(int $id,string $name,int $nbSeasons, string $language,int $nbEpisodes,int $nbNotes,string $country, string $image, string $producer, \DateTime $releaseDate, bool $forAdult, string $status) {
        $this->id = $id;
        $this->name = $name;
        $this->nbSeasons = $nbSeasons;
        $this->language = $language;
        $this->nbEpisodes = $nbEpisodes;
        $this->nbNotes = $nbNotes;
        $this->country = $country;
        $this->image = $image;
        $this->producer = $producer;
        $this->releaseDate = $releaseDate;
        $this->forAdult = $forAdult;
        $this->status = $status;
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

	/**
	 * @return int
	 */
	public function getNbEpisodes(): int {
		return $this->nbEpisodes;
	}
	
	/**
	 * @param int $nbEpisodes 
	 * @return self
	 */
	public function setNbEpisodes(int $nbEpisodes): self {
		$this->nbEpisodes = $nbEpisodes;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getNbNotes(): int {
		return $this->nbNotes;
	}

	public function setNbNotes(int $nbNotes): self {
		$this->nbNotes = $nbNotes;
		return $this;
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
	 * @return string
	 */
	public function getProducer(): string {
		return $this->producer;
	}
	
	/**
	 * @param string $producer 
	 * @return self
	 */
	public function setProducer(string $producer): self {
		$this->producer = $producer;
		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getReleaseDate(): \DateTime {
		return $this->releaseDate;
	}
	
	/**
	 * @param \DateTime $releaseDate 
	 * @return self
	 */
	public function setReleaseDate(\DateTime $releaseDate): self {
		$this->releaseDate = $releaseDate;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function getForAdult(): bool {
		return $this->forAdult;
	}
	
	/**
	 * @param bool $forAdult 
	 * @return self
	 */
	public function setForAdult(bool $forAdult): self {
		$this->forAdult = $forAdult;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getStatus(): string {
		return $this->status;
	}
	
	/**
	 * @param string $status 
	 * @return self
	 */
	public function setStatus(string $status): self {
		$this->status = $status;
		return $this;
	}
}