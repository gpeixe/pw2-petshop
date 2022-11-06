<?php

include_once("../db/sql-connection.php");
include_once("../db/pet-repository.php");
include_once("../controllers/pet-controller.php");
include_once("./helpers/http-helper.php");

$sqlConnection = SqlConnection::getConnection();
$petRepository = new PetRepository($sqlConnection);
$petController = new PetController($petRepository);

if (isPostRequest()) {
    $result = $petController->create($_POST);
    print_r("host: ", $host);
    if ($result) {
        $host = $_SERVER['HTTP_HOST'];
        
        //header("Location:http://$host/pw2-petshop/views/list-pets-view.php");
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
    <title>Cadastro de animais</title>
</head>

<body>
    <?php include_once("./includes/nav.php"); ?>
    <div class="c-wrapper">
        <div class="c-cadastro">
            <h2 class="c-titulo">Cadastro de Animais</h2>

            <form method="POST" class="c-formulario">
                <div class="c-campo">
                    <label for="nome">Nome</label>
                    <input type="text" name="name" id="name" class="text-input" required>
                </div>
                <div class="c-campo">
                    <label for="Raça">Raça</label>
                    <input type="text" name="breed" id="breed" class="text-input" required>
                </div>
                <div class="c-campo">
                    <label for="owerPhone">Telefone do dono</label>
                    <input type="tel" name="ownerPhone" id="ownerPhone" class="text-input" required placeholder="(xx) xxxxx-xxxx">
                </div>
                <button class="c-botao destaque" type="submit">Salvar</button>
            </form>
        </div>
    </div>
</body>

</html>