<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>

<body>
    <div class="container">
        <h2>Ocorreu um erro</h2>
        <p>
                <?php
                session_start();
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
        <p>Por favor, volte e tente novamente.</p>
        <button onclick="window.location.href='../index.php'">Voltar</button>
    </div>
        </body>

</html>