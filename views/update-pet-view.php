<?php

            include_once("../db/sql-connection.php");
            include_once("../db/pet-repository.php");
            include_once("../controllers/pet-controller.php");
            include_once("./helpers/http-helper.php");

            $sqlConnection = SqlConnection::getConnection();
            $petRepository = new PetRepository($sqlConnection);
            $petController = new PetController($petRepository);

            function navigateToListPetsView()
            {
                $host = $_SERVER['HTTP_HOST'];
                header("Location:http://$host/pw2-petshop/views/list-pets-view.php");
            }

            function redirectIfPetIdIsNotPresent()
            {
                if (!isset($_GET['petId']) || empty($_GET['petId'])) {
                    navigateToListPetsView();
                }
            }

            redirectIfPetIdIsNotPresent();

            $pet = $petController->getOne($_GET['petId']);

            if (!$pet) {
                navigateToListPetsView();
            }

            ?>

<!DOCTYPE html>
<html lang="pt-Br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/create.css">
    <title>Atualizar animal</title>
</head>

<body>
    <?php include_once("./includes/nav.php"); ?>
    <div class="c-wrapper">
        <div class="c-cadastro">
            <h2 class="c-titulo">Atualizar animal</h2>

            <form method="POST" class="c-formulario">
                <div class="c-campo">
                    <label for="nome">Nome</label>
                    <input type="text" value="<?php echo $pet->getName(); ?>" name="name" id="name" class="text-input" required>
                </div>
                <div class="c-campo">
                    <label for="Raça">Raça</label>
                    <input type="text" value="<?php echo $pet->getBreed(); ?>" name="breed" id="breed" class="text-input" required>
                </div>
                <div class="c-campo">
                    <label for="ownerPhone">Telefone do dono</label>
                    <input type="tel" value="<?php echo $pet->getOwnerPhone(); ?>" name="ownerPhone" id="ownerPhone" class="text-input" required placeholder="(xx) xxxxx-xxxx">
                </div>
                <button class="c-botao destaque" type="submit">Atualizar</button>
            </form>
            <?php 
            if (isPostRequest()) {
                try {
                    $_POST['id'] = $_GET['petId'];
                    $result = $petController->update($_POST);
                    if (gettype($result) === 'string') {
                        echo "<h3 class='error'>Parametro $result é obrigatório.</h3>";
                    } else {
                        navigateToListPetsView();
                    }
                } catch (Exception $e) {
                    $error = $e->getMessage();
                    echo "<h3 class='error'>$error</h3>";
                }
            } else 
            
            ?>
            
        </div>
    </div>
</body>

</html>