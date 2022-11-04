<?php 

include_once(dirname(__FILE__) . "/controller.php");
include_once(dirname(__FILE__) . "/../models/appointment.php");
include_once(dirname(__FILE__) . "/../models/pet.php");
include_once(dirname(__FILE__) . "/../models/employee.php");

class AppointmentController extends Controller {
    private $appointmentRepository;

    function __construct($appointmentRepository) {
        $this->appointmentRepository = $appointmentRepository;
    }

    function create($petId, $employeeId) {
        $response = $this->appointmentRepository->create($petId, $employeeId);
        return $response;
    }

    function getAll() {
        $appointmentsFromDb = $this->appointmentRepository->getAll();
        $appointments = array();
        foreach ($appointmentsFromDb as $appointmentFromDb) {
            $appointment = $this->_mapAppointmentFromDbToModel($appointmentFromDb);
            array_push($appointments, $appointment);
        }
        return $appointments;
    }

    function delete($appointmentId) {
        return $this->appointmentRepository->delete($appointmentId);
    }

    private function _mapAppointmentFromDbToModel($appointmentFromDb) {
        $appointment = new Appointment($appointmentFromDb['ID'], $appointmentFromDb['IDANIMAL'],  $appointmentFromDb['IDFUNCIONARIO'],  $appointmentFromDb['DATA']);
        $pet = new Pet($appointmentFromDb['NOMEANIMAL'], $appointmentFromDb['RACA'], $appointmentFromDb['TELDONO'], );
        $pet->setId($appointmentFromDb['IDANIMAL']);
        $employee = new Employee( $appointmentFromDb['NOMEFUNCIONARIO'],  $appointmentFromDb['EMAIL']);
        $employee->setId($appointmentFromDb['IDFUNCIONARIO']);
        $data = array($appointment, $pet, $employee);
        return $data;
    }
}

?>