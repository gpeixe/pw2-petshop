<?php

include_once("../db/sql-connection.php");
include_once("../db/employee-repository.php");
include_once("../controllers/employee-controller.php");
include_once("./helpers/http-helper.php");
$sqlConnection = SqlConnection::getConnection();
$employeeRepository = new EmployeeRepository($sqlConnection);
$employeeController = new EmployeeController($employeeRepository);

if (isPostRequest()) {
    $result = $employeeController->create($_POST);
    if ($result) {
        $host = $_SERVER['HTTP_HOST'];
        header("Location:http://$host/pw2-petshop/views/list-employees-view.php");
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
    <title>Cadastro de Funcionários</title>
</head>

<body>
    <?php include_once("./includes/nav.php"); ?>
    <div class="c-wrapper">
        <div class="c-cadastro">
            <h2 class="c-titulo">Cadastro de Funcionários</h2>

            <form method="POST" class="c-formulario">
                <div class="c-campo">
                    <label for="nome">Nome</label>
                    <input type="text" name="name" id="name" class="text-input" required>
                </div>
                <div class="c-campo">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="text-input" required>
                </div>
                <button class="c-botao destaque" type="submit">Salvar</button>
            </form>
        </div>
    </div>
</body>

</html>