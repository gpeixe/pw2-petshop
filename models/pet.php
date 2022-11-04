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
        $this->ownerPhone = $ownerPhone;
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