<?php

include_once("../db/sql-connection.php");
include_once("../db/pet-repository.php");
include_once("../controllers/pet-controller.php");
include_once("./helpers/http-helper.php");
include_once("../db/employee-repository.php");
include_once("../controllers/employee-controller.php");

$sqlConnection = SqlConnection::getConnection();
$petRepository = new PetRepository($sqlConnection);
$petController = new PetController($petRepository);
$employeeRepository = new EmployeeRepository($sqlConnection);
$employeeController = new EmployeeController($employeeRepository);
$host = $_SERVER['HTTP_HOST'];

if (isset($_GET['deleteId']) && !empty($_GET['deleteId'])) {
    $petId = $_GET['deleteId'];
    $petController->delete($petId);
} else if (isPostRequest() && isset($_POST['value'])) {
    print_r($_POST);
   
}
?>



<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/list.css">
    <title>Animais</title>
</head>

<body>
    <?php include_once("./includes/nav.php"); ?>
    <div class="a-wrapper">
        <div class="a-listagem">
            <form method="POST" class="a-procurar">
            <select name="filter" class="atributo" id="filter" onchange="this.form.submit()">
                    <?php 
                    
                        if (!isset($_POST['filter'])|| $_POST['filter'] === 'all') {
                            echo "<option selected value='all'>Todos os Pets</option>";
                            echo "<option  value='employeeName'>Nome do funcionário que cuida</option>";
                            echo "<option  value='breed'>Raça</option>";
                            echo "<option  value='employeeEmail'>Email do funcionário que cuida</option>";
                        } else if ($_POST['filter'] === 'employeeName') {
                            echo "<option value='all'>Todos os Pets</option>";
                            echo "<option selected value='employeeName'>Nome do funcionário que cuida</option>";
                            echo "<option  value='breed'>Raça</option>";
                            echo "<option  value='employeeEmail'>Email do funcionário que cuida</option>";
                        } else if ($_POST['filter'] === 'breed') {
                            echo "<option  value='all'>Todos os Pets</option>";
                            echo "<option  value='employeeName'>Nome do funcionário que cuida</option>";
                            echo "<option  selected value='breed'>Raça</option>";
                            echo "<option  value='employeeEmail'>Email do funcionário que cuida</option>";

                        } else if ($_POST['filter'] === 'employeeEmail') { 
                            echo "<option  value='all'>Todos os Pets</option>";
                            echo "<option  value='employeeName'>Nome do funcionário que cuida</option>";
                            echo "<option  selected value='breed'>Raça</option>";
                            echo "<option selected value='employeeEmail'>Email do funcionário que cuida</option>";
                        } 
                    ?>
                </select>
                <select onchange="this.form.submit()" name="value" id="gsearch" class="a-input" >
                    <?php
                    if (!isset($_POST['filter']) || $_POST['filter'] === "all")  echo "<option selected disabled value=''>Valores</option>";
                    else if (isset($_POST['filter'])) {
                        $data = null;
                        if ($_POST['filter'] === 'breed') {
                            $data = $petController->getAllBreeds();
                        }
                        if ($_POST['filter'] === 'employeeName') {
                            $data = $employeeController->getAll();
                            $names = array();
                            foreach ($data as $employee) {
                                array_push($names, $employee->getName());
                            }
                            $data = $names;
                        }
                        if ($_POST['filter'] === 'employeeEmail') {
                            $data = $employeeController->getAll();
                            $emails = array();
                            foreach ($data as $employee) {
                                array_push($emails, $employee->getEmail());
                            }
                            $data = $emails;
                        }
                        
                        foreach ($data as $value) {
                            if (isset($_POST['value']) && $_POST['value'] === $value) {
                                echo "<option selected value='$value'>$value</option>";
                            } else {
                                echo "<option value='$value'>$value</option>";
                            }
                            
                        }
                    }
                    ?>
                </select>
                <button class="a-buscar">Filtrar</button>
            </form>
            <table class="tabela">
                <tr class="a-titulo-tabela">
                    <td class="item">ID</td>
                    <td class="item">Nome</td>
                    <td class="item">Raça</td>
                    <td class="item">Telefone de dono</td>
                    <td class="item">Data do cadastro</td>
                    <td class="item">Editar</td>
                    <td class="item">Excluir</td>

                </tr>
                <?php
                $pets = null;
                if (isPostRequest() && isset($_POST['value']) && isset($_POST['filter'])) {
                    $value = $_POST['value'];
                    $filter = $_POST['filter'];
                    if ($filter === "breed") {
                        $pets = $petController->getAllByBreed($value);
                    } else if ($filter === "employeeName" || $filter === "employeeEmail"){
                        $pets = $petController->getAllByEmployeeNameOrEmail($value);
                    } else {
                        $pets = $petController->getAll();
                    }
                    
                } else {
                    $pets = $petController->getAll();
                }

                foreach ($pets as $pet) {
                    $petId = $pet->getId();
                    $petName = $pet->getName();
                    $petBreed = $pet->getBreed();
                    $ownerPhone = $pet->getOwnerPhone();
                    $createdAt = $pet->getCreatedAt();
                    echo '<tr>';
                    echo "<td class='item'>$petId</td>";
                    echo "<td class='item'>$petName</td>";
                    echo "<td class='item'>$petBreed</td>";
                    echo "<td class='item'>$ownerPhone</td>";
                    echo "<td class='item'>$createdAt</td>";
                    echo "<td class='item'><a href='http://$host/pw2-petshop/views/update-pet-view.php?petId=$petId'><img src='https://img.icons8.com/tiny-glyph/16/000000/edit.png'/></a></td>";
                    echo "<td class='item'><a href='http://$host/pw2-petshop/views/list-pets-view.php?deleteId=$petId'><img src='https://img.icons8.com/small/16/000000/trash--v3.png'/></a></td>";
                    echo "</tr>";
                }
                ?>
            </table>
            <a href="./create-pet-view.php" class="a-cadastro destaque">Cadastrar novo animal</a>
        </div>
    </div>
</body>

</html>
