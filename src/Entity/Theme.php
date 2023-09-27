<?php

namespace App\Entity;

// use Doctrine\Comon\Collections\Collection;

class Theme{
    private int $id;
    private string $name;

    public function __construct(int $id, string $name){
        $this->$id=$id;
        $this->$name=$name;
    }

	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}
	
	/**
	 * @param int $id 
	 * @return self
	 */
	public function setId(int $id): self {
		$this->id = $id;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName(): string {
		return $this->name;
	}
	
	/**
	 * @param string $name 
	 * @return self
	 */
	public function setName(string $name): self {
		$this->name = $name;
		return $this;
	}
}