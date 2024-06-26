<?php
session_start();

if (!isset($_SESSION['token'])) {
    header("Location: login.php");
    exit();
}
$mensagens = $_SESSION['mensagens'];
$_SESSION['novaMensagem'] = false;
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
        <h2>Mensagens:</h2>
        <?php if (!empty($mensagens)) : ?>
            <ul>
                <?php
                if (array_keys($mensagens) !== range(0, count($mensagens) - 1)) {
                    $mensagens = [$mensagens];
                }
                foreach ($mensagens as $mensagem) : 
                $statusClass = $mensagem['lida'] ? 'inativo' : 'ativo';
                ?>
                <li class="<?php echo $statusClass; ?>">
                    <p><strong>Empresa:</strong> <?php echo $mensagem['empresa']; ?></p>
                    <p><strong>mensagem:</strong> <?php echo $mensagem['mensagem']; ?></p>
                    <hr>
                </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>Nenhuma mensagem recebida.</p>
        <?php endif; ?>
        <form action="perfil.php" method="GET">
            <button type="submit">voltar</button>
        </form>
    </div>
</body>

</html>