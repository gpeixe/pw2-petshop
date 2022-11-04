<?php 

class EmployeeRepository {
    private $sqlConnection;

    function __construct($sqlConnection) {
        $this->sqlConnection = $sqlConnection;
    }

    function getAll() {
        $query = "SELECT * FROM FUNCIONÁRIO;";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getOne($employeeId) {
        $query = "SELECT * FROM FUNCIONÁRIO WHERE ID = ?;";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute([$employeeId]);
        $employeeFromDb = $stmt->fetchAll();
        if (!$employeeFromDb) return null;
        return $employeeFromDb[0];
    }

    function delete($employeeId) {
        $query = "DELETE FROM FUNCIONÁRIO WHERE ID = ?;";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute([$employeeId]);
        if ($stmt->rowCount() > 0) return true;
        else return false;
    }

    function update($employee) {
        $employeeName = $employee->getName();
        $employeeEmail = $employee->getEmail();
        $employeeId = $employee->getId();
        $query = "UPDATE FUNCIONÁRIO SET nome = ?, email = ? WHERE id = ?;";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute([$employeeName, $employeeEmail, $employeeId]);
        if ($stmt->rowCount() > 0) return true;
        else return false;
    }

    function create($employee) {
        $employeeName = $employee->getName();
        $employeeEmail = $employee->getEmail();
        $query = "INSERT INTO FUNCIONÁRIO (NOME, EMAIL, DATACADASTRO) VALUES (?, ?, NOW());";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute([$employeeName, $employeeEmail]);
        if ($stmt->rowCount() > 0) return true;
        else return false;
    }

    function getAllByPetName($petName) {
        $query = "SELECT FUNCIONÁRIO.NOME,  FUNCIONÁRIO.ID, FUNCIONÁRIO.DATACADASTRO, FUNCIONÁRIO.EMAIL FROM FUNCIONÁRIO INNER JOIN ATENDE ON FUNCIONÁRIO.id = ATENDE.idfuncionario INNER JOIN ANIMAL ON ATENDE.idanimal = ANIMAL.id WHERE ANIMAL.nome = ?;";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute([$petName]);
        return $stmt->fetchAll();
    }

}

?>