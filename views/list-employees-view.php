<?php

include_once("../db/sql-connection.php");
include_once("../db/employee-repository.php");
include_once("../controllers/employee-controller.php");
include_once("../db/pet-repository.php");
include_once("../controllers/pet-controller.php");
include_once("./helpers/http-helper.php");

$sqlConnection = SqlConnection::getConnection();
$employeeRepository = new EmployeeRepository($sqlConnection);
$employeeController = new EmployeeController($employeeRepository);
$petRepository = new PetRepository($sqlConnection);
$petController = new PetController($petRepository);
$host = $_SERVER['HTTP_HOST'];

if (isset($_GET['deleteId']) && !empty($_GET['deleteId'])) {
    $employeeId = $_GET['deleteId'];
    $employeeController->delete($employeeId);
}

?>



<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/list.css">
    <title>Funcionários</title>
</head>

<body>
    <?php include_once("./includes/nav.php"); ?>
    <div class="a-wrapper">
        <div class="a-listagem">
            <form method="POST" class="a-procurar">
                <select name="filter" class="atributo" id="filter" onchange="this.form.submit()">
                    <option <?php if (!isset($_POST['filter']))  echo "selected"; ?> value="all">Todos os funcionários</option>
                    <option <?php if (isset($_POST['filter']) && $_POST['filter'] === 'petName')  echo "selected"; ?> value="petName">Cuida do pet</option>
                </select>
                <select name="value" id="gsearch" class="a-input">
                    <?php
                    if (!isset($_POST['filter']) || $_POST['filter'] === "all")  echo "<option selected disabled value=''>Valores</option>";
                    else if ($_POST['filter'] === 'petName') {
                        $pets = $petController->getAll();
                        foreach ($pets as $pet) {
                            $petName = $pet->getName();
                            $selected = $_POST['value'] === $petName;
                            if ($selected) $option = "<option selected  value='$petName'>$petName</option>";
                            else  $option = "<option value='$petName'>$petName</option>";
                            echo $option;
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
                    <td class="item">Email</td>
                    <td class="item">Data do cadastro</td>
                    <td class="item">Editar</td>
                    <td class="item">Excluir</td>

                </tr>
                <?php
                $employees = null;
                if (isPostRequest() && isset($_POST['value']) && $_POST['filter']) {
                    $value = $_POST['value'];
                    $filter = $_POST['filter'];
                    if ($filter === "petName" && gettype($value) === "string") {
                        $employees = $employeeController->getAllByPetName($value);
                    } else {
                        $employees = $employeeController->getAll();
                    }
                } else {
                    $employees = $employeeController->getAll();
                }
                foreach ($employees as $employee) {
                    $id = $employee->getId();
                    $name = $employee->getName();
                    $email = $employee->getEmail();
                    $createdAt = $employee->getCreatedAt();
                    echo '<tr>';
                    echo "<td class='item'>$id</td>";
                    echo "<td class='item'>$name</td>";
                    echo "<td class='item'>$email</td>";
                    echo "<td class='item'>$createdAt</td>";
                    echo "<td class='item'><a href='http://$host/pw2-petshop/views/update-employee-view.php?employeeId=$id'><img src='https://img.icons8.com/tiny-glyph/16/000000/edit.png'/></a></td>";
                    echo "<td class='item'><a href='http://$host/pw2-petshop/views/list-employees-view.php?deleteId=$id'><img src='https://img.icons8.com/small/16/000000/trash--v3.png'/></a></td>";
                    echo "</tr>";
                }
                ?>
            </table>

            <a href="./create-employee-view.php" class="a-cadastro destaque">Cadastrar novo funcionário</a>
        </div>
    </div>
</body>

</html>