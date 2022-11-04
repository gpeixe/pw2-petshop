<?php

include_once("../db/sql-connection.php");
include_once("../db/appointment-repository.php");
include_once("../controllers/appointment-controller.php");
include_once("../db/employee-repository.php");
include_once("../controllers/employee-controller.php");
include_once("../db/pet-repository.php");
include_once("../controllers/pet-controller.php");
include_once("./helpers/http-helper.php");


$sqlConnection = SqlConnection::getConnection();
$appointmentRepository = new AppointmentRepository($sqlConnection);
$appointmentController = new AppointmentController($appointmentRepository);
$employeeRepository = new EmployeeRepository($sqlConnection);
$employeeController = new EmployeeController($employeeRepository);
$petRepository = new PetRepository($sqlConnection);
$petController = new PetController($petRepository);

function navigateToListAppointmentsView()
{
    header("Location:http://54.242.27.17/pw2-petshop/views/list-appointments-view.php");
}




if (isPostRequest()) {
    $employeeId =$_POST['employeeId'];
    $petId = $_POST['petId'];
    $result = $appointmentController->create($petId, $employeeId);
    if ($result) {
        navigateToListAppointmentsView();
    }
}

?>

<!DOCTYPE html>
<html lang="pt-Br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/create.css">
    <title>Cadastro de atendimento</title>
</head>

<body>
    <?php include_once("./includes/nav.php"); ?>
    <div class="c-wrapper">
        <div class="c-cadastro">
            <h2 class="c-titulo">Cadastro de atendimento</h2>

            <form method="POST" class="c-formulario">
                <div class="c-campo">
                    <label for="petId">Selecionar Pet</label>
                    <select name="petId" id="petId">
                        <?php 
                        $pets = $petController->getAll();
                        foreach($pets as $pet) {
                            $petId = $pet->getId();
                            $petName = $pet->getName();
                            echo "<option value='$petId'>$petName</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="c-campo">
                <label for="employeeId">Selecionar funcionário</label>
                    <select name="employeeId" id="employeeId">
                        <?php 
                        $employees = $employeeController->getAll();
                            foreach($employees as $employee) {
                                $employeeId = $employee->getId();
                                $employeeName = $employee->getName();
                                echo "<option value='$employeeId'>$employeeName</option>";
                            }
                        ?>
                    </select>
                </div>
                <button class="c-botao destaque" type="submit">Salvar</button>
            </form>
        </div>
    </div>
</body>

</html>