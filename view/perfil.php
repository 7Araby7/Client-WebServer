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
    <title>Perfil</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container">
        <div class="profile">
            <img src="../css/profile.png" alt="Foto de Perfil">
            <form action="../controller/ler_controller.php" method="POST">
                <input type="hidden" name="pagina" value="lista">
                <button type="submit">Informações do Usuario</button>
            </form>
            <form action="../controller/ler_controller.php" method="POST">
                <input type="hidden" name="pagina" value="editar">
                <button type="submit">Editar Usuario</button>
            </form>
            <form action="../controller/logout_controller.php" method="POST">
                <input type="hidden" name="logout" value="<?php echo $_SESSION['token']; ?>">
                <button type="submit" onclick="return confirm('Tem certeza que deseja sair?')">SAIR</button>
            </form>
            <form action="../controller/delete_controller.php" method="POST">
                <input type="hidden" name="delete" value="<?php echo $_SESSION['token']; ?>">
                <button type="submit" onclick="return confirm('Tem certeza que deseja excluir sua conta?\n\tEssa ação não é reversível')">Excluir conta</button>
            </form>
        </div>
    </div>
</body>

</html>