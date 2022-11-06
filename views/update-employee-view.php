


<!DOCTYPE html>
<html lang="pt-Br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/create.css">
    <title>Atualizar Funcionário</title>
</head>

<body>
    <?php include_once("./includes/nav.php"); ?>
    <div class="c-wrapper">
        <div class="c-cadastro">
            <h2 class="c-titulo">Atualizar Funcionário</h2>

            <form method="POST" class="c-formulario">
                <div class="c-campo">
                    <label for="nome">Nome</label>
                    <input type="text" value="<?php echo $employee->getName(); ?>" name="name" id="name" class="text-input">
                </div>
                <div class="c-campo">
                    <label for="email">Email</label>
                    <input type="email" value="<?php echo $employee->getEmail(); ?>" name="email" id="email" class="text-input" required>
                </div>
                <button class="c-botao destaque" type="submit">Atualizar</button>
            </form>
        </div>
        <?php

include_once("../db/sql-connection.php");
include_once("../db/employee-repository.php");
include_once("../controllers/employee-controller.php");
include_once("./helpers/http-helper.php");

$sqlConnection = SqlConnection::getConnection();
$employeeRepository = new EmployeeRepository($sqlConnection);
$employeeController = new EmployeeController($employeeRepository);

function navigateToListEmployeesView()
{
    $host = $_SERVER['HTTP_HOST'];
    header("Location:http://$host/pw2-petshop/views/list-employees-view.php");
}

function redirectIfEmployeeIdIsNotPresent()
{
    if (!isset($_GET['employeeId']) || empty($_GET['employeeId'])) {
        navigateToListEmployeesView();
    }
}

redirectIfEmployeeIdIsNotPresent();

$employee = $employeeController->getOne($_GET['employeeId']);

if (isPostRequest()) {
    try {
        $_POST['id'] = $_GET['employeeId'];
        $result = $employeeController->update($_POST);
        if (gettype($result) === 'string') {
            echo "<h3>Parametro $result é obrigatório.</h3>";
        } else {
            navigateToListEmployeesView();
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
        echo "<h3>$error</h3>";
    }
} else if (!$employee) {
    navigateToListEmployeesView();
}

?>


    </div>
</body>

</html>

