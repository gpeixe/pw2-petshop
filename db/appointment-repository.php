<?php 

class AppointmentRepository {
    private $sqlConnection;

    function __construct($sqlConnection) {
        $this->sqlConnection = $sqlConnection;
    }

    function delete($appointmentId) {
        $query = "DELETE FROM ATENDE WHERE ID = ?";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute([$appointmentId]);
        if ($stmt->rowCount() > 0) return true;
        else return false;
    }

    function getAll() {
        $query = "SELECT ATENDE.ID as ID, IDFUNCIONARIO, IDANIMAL, DATA, FUNCIONÁRIO.NOME AS NOMEFUNCIONARIO, ANIMAL.NOME AS NOMEANIMAL, EMAIL, TELDONO, RACA
         FROM ATENDE INNER JOIN ANIMAL ON ANIMAL.ID = ATENDE.IDANIMAL INNER JOIN FUNCIONÁRIO ON FUNCIONÁRIO.ID = ATENDE.IDFUNCIONARIO";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute();
        $appointments = $stmt->fetchAll();
        return $appointments;
    }

    function create($petId, $employeeId) {
        $query = "INSERT INTO ATENDE (idanimal, idfuncionario, data) VALUES (?, ?, NOW())";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute([$petId, $employeeId]);
        if ($stmt->rowCount() > 0) return true;
        else return false;
    }
}

?>