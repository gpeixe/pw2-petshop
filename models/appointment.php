<?php 

class Appointment {
    private $id;
    private $petId;
    private $employeeId;
    private $createdAt;

    function __construct($id, $petId, $employeeId, $createdAt) {
        $this->id = $id;
        $this->petId = $petId;
        $this->employeeId = $employeeId;
        $this->createdAt = $createdAt;
    }

    function getId () {
        return $this->id;
    }

    function getPetId () {
        return $this->petId;
    }

    function getEmployeeId () {
        return $this->employeeId;
    }

    function getCreatedAt () {
        return $this->createdAt;
    }
}

?>