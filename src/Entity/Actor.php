<?php     namespace App\Entity;

class Actor {
    private int $id;
    private string $firstname;
    private bool $gender;
    private string $name;
    private string $biographie;

    public function __construct(int $id, string $firstname, bool $gender, string $name, string $biographie){
        $this->id=$id;
        $this->firstname=$firstname;
        $this->gender=$gender;
        $this->name=$name;
        $this->biographie=$biographie;
    }

    public function getId():int{
        return $this->id;
    }

    public function setId(int $value): void{
        $this->id=$value;
    }

    public function getFirstName(): string{
        return $this->firstname;
    }

    public function setFirstName(bool $value): void{
        $this->firstname=$value;
    }

    public function getGender(): bool{
        return $this->gender;
    }

    public function setGender(bool $value): void{
        $this->gender=$value;
    }

    public function getName(): string{
        return $this->name;
    }

    public function setName(bool $value): void{
        $this->name=$value;
    }
    
    public function getBiographie(): string{
        return $this->biographie;
    }

    public function setBiographie(bool $value): void{
        $this->biographie=$value;
    }

}