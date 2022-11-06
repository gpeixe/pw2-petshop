<?php 

class PetRepository {
    private $sqlConnection;

    function __construct($sqlConnection) {
        $this->sqlConnection = $sqlConnection;
    }

    function getAll() {
        $query = "SELECT * FROM animal;";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getOne($petId) {
        $query = "SELECT * FROM animal WHERE ID = $petId;";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute();
        $petFromDb = $stmt->fetchAll();
        if (!$petFromDb) return null;
        return $petFromDb[0];
    }

    function delete($petId) {
        $query = "DELETE FROM animal WHERE ID = ?;";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute([$petId]);
        if ($stmt->rowCount() > 0) return true;
        else return false;
    }

    function update($pet) {
        $petName = $pet->getName();
        $petBreed = $pet->getBreed();
        $ownerPhone = $pet->getOwnerPhone();
        $petId = $pet->getId();
        $query = "UPDATE animal SET NOME = ?, RACA = ?, TELDONO = ? WHERE id = ?;";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute([$petName, $petBreed, $ownerPhone, $petId]);
        if ($stmt->rowCount() > 0) return true;
        else return false;
    }

    function create($pet) {
        $petName = $pet->getName();
        $petBreed = $pet->getBreed();
        $ownerPhone = $pet->getOwnerPhone();
        $query = "INSERT INTO animal (NOME, RACA, TELDONO, DATACADASTRO) VALUES (?, ?, ?, NOW());";
        try {
            $stmt =  $this->sqlConnection->prepare($query);
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
        $stmt->execute([$petName, $petBreed, $ownerPhone]);
        if ($stmt->rowCount() > 0) return true;
        else return false;
    }

    function getAllByEmployeeNameOrEmail($employeeNameOrEmail) {
        $query = "";
        if (filter_var($employeeNameOrEmail, FILTER_VALIDATE_EMAIL)) {
            $query = "SELECT animal.ID, animal.NOME , animal.RACA, animal.DATACADASTRO, animal.TELDONO FROM animal INNER JOIN atende ON animal.id = atende.idanimal INNER JOIN funcionário ON funcionário.id = atende.idfuncionario WHERE funcionário.email = ?;";
        } else {
            $query = "SELECT animal.ID, animal.NOME , animal.RACA, animal.DATACADASTRO, animal.TELDONO  FROM animal INNER JOIN atende ON animal.id = atende.idanimal INNER JOIN funcionário ON funcionário.id = atende.idfuncionario WHERE funcionário.NOME = ?;";
        }
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute([$employeeNameOrEmail]);
        return $stmt->fetchAll();
    }

    function getAllBreeds() {
        $query = "SELECT DISTINCT(RACA) FROM animal;";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute();
        $breeds = $stmt->fetchAll();
        return $breeds;
    }

    function getAllByBreed($breed) {
        $query = "SELECT * FROM animal WHERE RACA = ?;";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute([$breed]);
        return $stmt->fetchAll();
    }

    function getAllByOwnerPhone($ownerPhone) {
        $query = "SELECT * FROM animal WHERE TELDONO = ?;";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute([$ownerPhone]);
        return $stmt->fetchAll();
    }
}

?>