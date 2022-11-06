<?php 

class AppointmentRepository {
    private $sqlConnection;

    function __construct($sqlConnection) {
        $this->sqlConnection = $sqlConnection;
    }

    function delete($appointmentId) {
        $query = "DELETE FROM atende WHERE ID = ?";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute([$appointmentId]);
        if ($stmt->rowCount() > 0) return true;
        else return false;
    }

    function getAll() {
        $query = "SELECT atende.ID as ID, IDFUNCIONARIO, IDANIMAL, DATA, funcionário.NOME AS NOMEFUNCIONARIO, animal.NOME AS NOMEANIMAL, EMAIL, TELDONO, RACA
         FROM atende INNER JOIN animal ON animal.ID = atende.IDANIMAL INNER JOIN funcionário ON funcionário.ID = atende.IDFUNCIONARIO";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute();
        $appointments = $stmt->fetchAll();
        return $appointments;
    }

    function create($petId, $employeeId) {
        $query = "INSERT INTO atende (idanimal, idfuncionario, data) VALUES (?, ?, NOW())";
        $stmt =  $this->sqlConnection->prepare($query);
        $stmt->execute([$petId, $employeeId]);
        if ($stmt->rowCount() > 0) return true;
        else return false;
    }
}

?>