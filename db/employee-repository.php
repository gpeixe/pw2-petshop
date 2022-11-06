<?php 

class EmployeeRepository {
    private $sqlConnection;

    function __construct($sqlConnection) {
        $this->sqlConnection = $sqlConnection;
    }

    function getAll() {
        $query = "SELECT * FROM funcionário;";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getOne($employeeId) {
        $query = "SELECT * FROM funcionário WHERE ID = ?;";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute([$employeeId]);
        $employeeFromDb = $stmt->fetchAll();
        if (!$employeeFromDb) return null;
        return $employeeFromDb[0];
    }

    function delete($employeeId) {
        $query = "DELETE FROM funcionário WHERE ID = ?;";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute([$employeeId]);
        if ($stmt->rowCount() > 0) return true;
        else return false;
    }

    function update($employee) {
        try {
        $employeeName = $employee->getName();
        $employeeEmail = $employee->getEmail();
        $employeeId = $employee->getId();
        $query = "UPDATE funcionário SET nome = ?, email = ? WHERE id = ?;";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute([$employeeName, $employeeEmail, $employeeId]);
        if ($stmt->rowCount() > 0) return true;
        else return false;
    } catch (Exception $e) {
        throw new ErrorException('Email já cadastrado.');
    }
    }

    function create($employee) {
        try {
            $employeeName = $employee->getName();
            $employeeEmail = $employee->getEmail();
            $query = "INSERT INTO funcionário (NOME, EMAIL, DATACADASTRO) VALUES (?, ?, NOW());";
            $stmt =  $this->sqlConnection->prepare($query);
            $stmt->execute([$employeeName, $employeeEmail]);
            if ($stmt->rowCount() > 0) return true;
            else return false;
        } catch (Exception $e) {
            throw new ErrorException('Email já cadastrado.');
        }
       
    }

    function getAllByPetName($petName) {
        $query = "SELECT funcionário.NOME,  funcionário.ID, funcionário.DATACADASTRO, funcionário.EMAIL FROM funcionário INNER JOIN atende ON funcionário.id = atende.idfuncionario INNER JOIN animal ON atende.idanimal = animal.id WHERE animal.nome = ?;";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute([$petName]);
        return $stmt->fetchAll();
    }

}
