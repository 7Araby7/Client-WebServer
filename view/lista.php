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
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container">
        <h2>Perfil do Usuário</h2>
        <p><strong>Nome:</strong> <?php echo $_SESSION['nome']; ?></p>
        <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
        <p><strong>Tipo:</strong> <?php echo $_SESSION['tipo']; ?></p>

        <h3>Competências:</h3>
        <ul>
            <?php foreach ($_SESSION['competenciasCand'] as $competencia): ?>
                <li>
                    ID: <?php echo $competencia['id']; ?><br>
                    Nome: <?php echo $competencia['nome']; ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <h3>Experiências:</h3>
        <ul>
            <?php foreach ($_SESSION['experiencia'] as $experiencia): ?>
                <li>
                    ID: <?php echo $experiencia['id']; ?><br>
                    Nome da Empresa: <?php echo $experiencia['nome_empresa']; ?><br>
                    Início: <?php echo $experiencia['inicio']; ?><br>
                    Fim: <?php echo $experiencia['fim']; ?><br>
                    Cargo: <?php echo $experiencia['cargo']; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <form action="perfil.php" method="GET">
            <button type="submit">voltar</button>
        </form>
    </div>
</body>

</html>