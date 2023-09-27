<?php     namespace App\Entity;

class Actor {
    private int $id;
    private string $name;
    private int $gender;
    private string $character;

    public function __construct(int $id=0, int $gender=-1, string $name="", string $character=""){
        $this->id=$id;
        $this->gender=$gender;
        $this->name=$name;
        $this->character=$character;
    }

    public function getId():int{
        return $this->id;
    }

    public function setId(int $value): void{
        $this->id=$value;
    }


    public function getGender(): int{
        return $this->gender;
    }

    public function setGender(int $value): void{
        $this->gender=$value;
    }

    public function getName(): string{
        return $this->name;
    }

    public function setName(bool $value): void{
        $this->name=$value;
    }
    
    public function getCharacter(): string{
        return $this->character;
    }

    public function setCharacter(bool $value): void{
        $this->character=$value;
    }

}