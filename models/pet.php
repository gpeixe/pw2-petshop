<?php 

class Pet {
    private $id;
    private $name;
    private $breed;
    private $ownerPhone;
    private $createdAt;

    function __construct($name, $breed, $ownerPhone) {
        $this->name = $name;
        $this->breed = $breed;
        $this->setOwnerPhone($ownerPhone);
    }

    function setOwnerPhone($ownerPhone) {
        $exp = "/^\d{11}$/i";
        $isValidPhone = preg_match($exp, $ownerPhone);
        if ($isValidPhone) {
            $this->ownerPhone = $ownerPhone;
            print_r("nao deu erro pet;");
        } else {
            print_r("deu erro pet;");
          throw new ErrorException('Telefone do dono deve ser 11 números em sequencia.');
        }

    }

    function getId () {
        return $this->id;
    }

    function getName () {
        return $this->name;
    }

    function getBreed () {
        return $this->breed;
    }

    function getOwnerPhone () {
        return $this->ownerPhone;
    }

    function getCreatedAt () {
        return $this->createdAt;
    }

    function setId ($id) {
        $this->id = $id;
    }

    function setCreatedAt ($createdAt) {
        $this->createdAt = $createdAt;
    }
}

?>