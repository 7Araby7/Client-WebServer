<?php
session_start();
if (!isset($_SESSION['serverIP'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container">
        <h2>Cadastrar Usuário</h2>
        <form action="../controller/cadastro_controller.php" method="POST">
            <p>
                <?php
                if (!empty($_SESSION['erro'])): ?>
                    <?php if ($_SESSION['erro']): ?>
                        <div class="warning">
                            <?php echo $_SESSION['mensagem_erro']?>
                        </div>
                <?php endif ?>
                <?php $_SESSION['erro'] = false; endif ?>
            </p>
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="senha" placeholder="Senha" minlength="8" required>
            <button type="submit">Registrar</button>
        </form>
        <p><a href="cadastroEmp.php">Cadastrar empresa</a></p>
        <p>Já tem uma conta? <a href="login.php">Faça login</a></p>
    </div>
</body>

</html>