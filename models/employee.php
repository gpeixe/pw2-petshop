<?php 

class Employee {
    private $id;
    private $name;
    private $email;
    private $createdAt;

    function __construct($name, $email) {
        $this->name = $name;
        $this->email = $email;
    }

    function setCreatedAt ($createdAt) {
        $this->createdAt = $createdAt;
    }

    function setId ($id) {
        $this->id = $id;
    }

    function getId () {
        return $this->id;
    }

    function getName () {
        return $this->name;
    }

    function getEmail () {
        return $this->email;
    }

    function getCreatedAt () {
        return $this->createdAt;
    }


    function setName ($name) {
        $this->name = $name;
    }

    function setEmail($email) {
        $this->email = $email;
    }
}

?>