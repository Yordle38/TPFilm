<?php 

namespace App\Entity;
class Serie {
    private int $id;
    private string $name;
	private string $overview;
    private int $nbSeasons;
    private string $language;
    private int $nbEpisodes;
    private int $nbNotes;
	private float $avgNote;

    private string $country;
    private string $image;
    private \DateTime $releaseDate;
    private bool $forAdult;


    public function __construct(int $id,string $name,string $overview, int $nbSeasons, string $language,int $nbEpisodes,int $nbNotes,int $avgNote,string $country, string $image, \DateTime $releaseDate, bool $forAdult) {
        $this->id = $id;
        $this->name = $name;
        $this->nbSeasons = $nbSeasons;
        $this->language = $language;
        $this->nbEpisodes = $nbEpisodes;
        $this->nbNotes = $nbNotes;
        $this->country = $country;
        $this->image = $image;
        $this->releaseDate = $releaseDate;
        $this->forAdult = $forAdult;
		$this->avgNote=$avgNote;
		$this->overview=$overview;
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

    // Getter pour overview
    public function getOverview(): string {
        return $this->overview;
    }

    // Setter pour overview
    public function setOverview(string $overview): void {
        $this->overview = $overview;
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
	 * @return float
	 */
	public function getavgNote(): float {
		return $this->avgNote;
	}

	public function setAvgNote(float $avgNote): self {
		$this->avgNote = $avgNote;
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

}