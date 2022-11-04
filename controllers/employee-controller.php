<?php 

include_once(dirname(__FILE__) . "/controller.php");
include_once(dirname(__FILE__) . "/../models/employee.php");

class EmployeeController extends Controller {
    private $employeeRepository;

    function __construct($employeeRepository) {
        $this->employeeRepository = $employeeRepository;
    }

    function getAll() {
        $employeesFromDb = $this->employeeRepository->getAll();
        $employees = array();
        foreach ($employeesFromDb as $employeeFromDb) {
            $employee = $this->_mapEmployeeFromDbToModel($employeeFromDb);
            array_push($employees, $employee);
        }
        return $employees;
    }

    function getOne($employeeId) {
        $employeeFromDb = $this->employeeRepository->getOne($employeeId);
        if(!$employeeFromDb) return null;
        $employee = $this->_mapEmployeeFromDbToModel($employeeFromDb);
        return $employee;
    }

    function delete($employeeId) {
        return $this->employeeRepository->delete($employeeId);
    }

    function update($employeeToUpdate) {
        $error = parent::_validateRequestFields(['id', 'name', 'email'], $employeeToUpdate);
        if ($error) return $error;
        $id = $employeeToUpdate['id'];
        $name = $employeeToUpdate['name'];
        $email = $employeeToUpdate['email'];
        $employee = new Employee($name, $email);
        $employee->setId($id);
        return $this->employeeRepository->update($employee);
    }

    function create($post) {
        $error = parent::_validateRequestFields(['name', 'email'], $post);
        if ($error) return $error;
        $name = $_POST['name'];
        $email = $_POST['email'];
        $employee = new Employee($name, $email);
        return $this->employeeRepository->create($employee);
    }

    function getAllByPetName($petName) {
        $employeesFromDb = $this->employeeRepository->getAllByPetName($petName);
        $employees = array();
        foreach ($employeesFromDb as $employeeFromDb) {
            $employee = $this->_mapEmployeeFromDbToModel($employeeFromDb);
            array_push($employees, $employee);
        }
        return $employees;
    }

    private function _mapEmployeeFromDbToModel($employeeFromDb) {
        $employee = new Employee($employeeFromDb['NOME'], $employeeFromDb['EMAIL']);
        $employee->setId($employeeFromDb['ID']);
        $employee->setCreatedAt($employeeFromDb['DATACADASTRO']);
        return $employee;
    }
}

?>