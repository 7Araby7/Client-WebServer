<?php
session_start();
if (!isset($_SESSION['token'])) {
    header("Location: login.php");
    exit();
}
$empresa = $_SESSION['empresa'];
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
        <ul>
            <li>
                <p><strong>Nome:</strong> <?php echo $empresa['nome']; ?></p>
                <p><strong>Email:</strong> <?php echo $empresa['email']; ?></p>
                <p><strong>Ramo:</strong> <?php echo $empresa['ramo']; ?></p>
                <p><strong>Descrição:</strong> <?php echo $empresa['descricao']; ?></p>
            </li>
        </ul>
        <form action="perfil.php" method="GET">
            <button type="submit">Voltar</button>
        </form>
    </div>
</body>

</html>