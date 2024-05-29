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
    <title>Perfil da Empresa</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container">
        <h2>Perfil da Empresa</h2>
        <p><strong>Nome:</strong> <?php echo $_SESSION['nome_empresa']; ?></p>
        <p><strong>Email:</strong> <?php echo $_SESSION['email_empresa']; ?></p>
        <p><strong>Ramo:</strong> <?php echo $_SESSION['ramo']; ?></p>
        <p><strong>Descrição:</strong> <?php echo $_SESSION['descricao']; ?></p>

        <form action="perfil.php" method="GET">
            <button type="submit">Voltar</button>
        </form>
    </div>
</body>

</html>
