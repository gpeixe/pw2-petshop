<?php 

class PetRepository {
    private $sqlConnection;

    function __construct($sqlConnection) {
        $this->sqlConnection = $sqlConnection;
    }

    function getAll() {
        $query = "SELECT * FROM ANIMAL;";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getOne($petId) {
        $query = "SELECT * FROM ANIMAL WHERE ID = $petId;";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute();
        $petFromDb = $stmt->fetchAll();
        if (!$petFromDb) return null;
        return $petFromDb[0];
    }

    function delete($petId) {
        $query = "DELETE FROM ANIMAL WHERE ID = ?;";
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
        $query = "UPDATE ANIMAL SET nome = ?, raca = ?, teldono = ? WHERE id = ?;";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute([$petName, $petBreed, $ownerPhone, $petId]);
        if ($stmt->rowCount() > 0) return true;
        else return false;
    }

    function create($pet) {
        $petName = $pet->getName();
        $petBreed = $pet->getBreed();
        $ownerPhone = $pet->getOwnerPhone();
        $query = "INSERT INTO ANIMAL (NOME, RACA, TELDONO, DATACADASTRO) VALUES (?, ?, ?, NOW());";
        print_r("preparing query: " . $query);
        try {
            $stmt =  $this->sqlConnection->prepare($query);
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
        print_r("executing query...");
        $stmt->execute([$petName, $petBreed, $ownerPhone]);
        print_r("finish query...");
        if ($stmt->rowCount() > 0) return true;
        else return false;
    }

    function getAllByEmployeeNameOrEmail($employeeNameOrEmail) {
        $query = "";
        if (filter_var($employeeNameOrEmail, FILTER_VALIDATE_EMAIL)) {
            $query = "SELECT ANIMAL.ID, ANIMAL.NOME , ANIMAL.RACA, ANIMAL.DATACADASTRO, ANIMAL.TELDONO FROM ANIMAL INNER JOIN ATENDE ON ANIMAL.id = ATENDE.idanimal INNER JOIN FUNCIONÁRIO ON FUNCIONÁRIO.id = ATENDE.idfuncionario WHERE FUNCIONÁRIO.email = ?;";
        } else {
            $query = "SELECT ANIMAL.ID, ANIMAL.NOME , ANIMAL.RACA, ANIMAL.DATACADASTRO, ANIMAL.TELDONO  FROM ANIMAL INNER JOIN ATENDE ON ANIMAL.id = ATENDE.idanimal INNER JOIN FUNCIONÁRIO ON FUNCIONÁRIO.id = ATENDE.idfuncionario WHERE FUNCIONÁRIO.nome = ?;";
        }
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute([$employeeNameOrEmail]);
        return $stmt->fetchAll();
    }

    function getAllBreeds() {
        $query = "SELECT DISTINCT(RACA) FROM ANIMAL;";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute();
        $breeds = $stmt->fetchAll();
        return $breeds;
    }

    function getAllByBreed($breed) {
        $query = "SELECT * FROM ANIMAL WHERE raca = ?;";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute([$breed]);
        return $stmt->fetchAll();
    }

    function getAllByOwnerPhone($ownerPhone) {
        $query = "SELECT * FROM ANIMAL WHERE teldono = ?;";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute([$ownerPhone]);
        return $stmt->fetchAll();
    }
}

?>