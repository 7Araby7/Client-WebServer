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
    <link rel="stylesheet" href="../css/style.css">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <h2>Login</h2>
        <form action="../controller/login_controller.php" method="POST">
            <p>
                <?php
                if (!empty($_SESSION['erro'])):
                    if ($_SESSION['erro']): ?>
                        <div class="warning">
                            <?php echo $_SESSION['mensagem_erro']?>
                        </div>
                <?php endif;
                $_SESSION['erro'] = false;
                endif;
                ?>
            </p>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="senha" placeholder="Senha" minlength="8" required><br>
            <button type="submit">Entrar</button>
        </form>
        <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se</a></p>
    </div>
</body>

</html>
