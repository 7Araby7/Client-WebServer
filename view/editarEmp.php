<?php
session_start();
if (!isset($_SESSION['serverIP'])) {
    header("Location: ../index.php");
    exit();
}
$empresa = $_SESSION['empresa'];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Usuário</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container">
        <h2>Alterar Empresa</h2>
        <form action="../controller/editarEmp_controller.php" method="POST">
            <p>
                <?php
                if (!empty($_SESSION['erro'])) : ?>
                    <?php if ($_SESSION['erro']) : ?>
            <div class="warning">
                <?php echo $_SESSION['mensagem_erro'] ?>
            </div>
        <?php endif ?>
    <?php $_SESSION['erro'] = false;
                endif ?>
    </p>
    <h3>Nome</h3>
    <hr>
    <input type="text" name="nome" placeholder="Nome da Empresa" value="<?php echo $empresa['nome']; ?>" required>
    <h3>Email</h3>
    <hr>
    <input type="email" name="email" placeholder="Email" value="<?php echo $empresa['email']; ?>" required>
    <h3>Senha</h3>
    <hr>
    <input type="password" name="senha" placeholder="Senha" minlength="8">
    <h3>Ramo</h3>
    <hr>
    <input type="text" name="ramo" placeholder="Ramo de Atuação" value="<?php echo $empresa['ramo']; ?>" minlength="3" required>
    <h3>Descrição</h3>
    <hr>
    <textarea name="descricao" placeholder="Descrição da Empresa" minlength="10" rows="4" required><?php echo $empresa['descricao']; ?></textarea>
    <button type="submit">Alterar</button>
        </form>
    </div>
</body>

</html>