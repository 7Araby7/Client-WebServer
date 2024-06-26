<?php
session_start();
if (!isset($_SESSION['token'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vagas</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container">
        <div class="profile">
            <div class="wrapper">
                <img src="../css/profile3.png" alt="Foto de Perfil" class="pedro">
            </div>
            <form action="perfil.php" method="GET">
                <button type="submit">Perfil</button>
            </form>
            <form action="cadastroVaga.php" method="GET">
                <button type="submit">Cadastrar vaga</button>
            </form>
            <form action="../controller/lerVagas_controller.php" method="GET">
                <button type="submit">Ver vagas</button>
            </form>
            <form action="../controller/buscarVaga_controller.php" method="POST" >
                <input type="hidden" name="pagina" value="vagaId">
                <input type="number" name="id" placeholder="Pesquisar vaga por ID">
                <button type="submit" >Pesquisar</button>
            </form>
        </div>
    </div>
</body>

</html>