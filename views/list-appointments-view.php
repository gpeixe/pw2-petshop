<?php

include_once("../db/sql-connection.php");
include_once("../db/appointment-repository.php");
include_once("../controllers/appointment-controller.php");
include_once("../db/employee-repository.php");
include_once("../controllers/employee-controller.php");
include_once("../db/pet-repository.php");
include_once("../controllers/pet-controller.php");

$host = $_SERVER['HTTP_HOST'];
$sqlConnection = SqlConnection::getConnection();
$appointmentRepository = new AppointmentRepository($sqlConnection);
$appointmentController = new AppointmentController($appointmentRepository);


if (isset($_GET['deleteId']) && !empty($_GET['deleteId'])) {
    $appointmentId = $_GET['deleteId'];
    $appointmentController->delete($appointmentId);
}

?>



<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/list.css">
    <title>Atendimentos</title>
</head>

<body>
    <?php include_once("./includes/nav.php"); ?>
    <div class="a-wrapper">
        <div class="a-listagem">
            <table class="tabela">
                <tr class="a-titulo-tabela">
                    <td class="item">ID</td>
                    <td class="item">Id do Pet</td>
                    <td class="item">Nome do Pet</td>
                    <td class="item">Tel do dono</td>
                    <td class="item">Id do Funcionário</td>
                    <td class="item">Nome do Funcionário</td>
                    <td class="item">Email do Funcionário</td>
                    <td class="item">Data</td>
                    <td class="item">Excluir</td>

                </tr>
                <?php
                $appointments = $appointmentController->getAll();
                foreach ($appointments as $data) {
                    $appointment = $data[0];
                    $pet = $data[1];
                    $employee = $data[2];
                    $id = $appointment->getId();
                    $petId = $appointment->getPetId();
                    $petName = $pet->getName();
                    $ownerPhone = $pet->getOwnerPhone();
                    $employeeId = $employee->getId();
                    $employeeName = $employee->getName();
                    $email = $employee->getEmail();
                    $date = $appointment->getCreatedAt();
                    echo '<tr>';
                    echo "<td class='item'>$id</td>";
                    echo "<td class='item'>$petId</td>";
                    echo "<td class='item'>$petName</td>";
                    echo "<td class='item'>$ownerPhone</td>";
                    echo "<td class='item'>$employeeId</td>";
                    echo "<td class='item'>$employeeName</td>";
                    echo "<td class='item'>$email</td>";
                    echo "<td class='item'>$date</td>";
                    echo "<td class='item'><a href='http://$host/pw2-petshop/views/list-appointments-view.php?deleteId=$id'><img src='https://img.icons8.com/small/16/000000/trash--v3.png'/></a></td>";
                    echo "</tr>";
                }
                ?>
            </table>

            <a href="./create-appointment-view.php" class="a-cadastro destaque">Cadastrar novo atendimento</a>
        </div>
    </div>
</body>

</html>