<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>connect</title>
</head>

<body>
    <div class="container">
        <h2>Informe o IP do Servidor</h2>
        <form action="controller/conectar_controller.php" method="POST">
            <label for="ip">IP do Servidor:</label>
            <input type="text" id="ip" name="ip" required>
            <button type="submit">Conectar</button>
        </form>
        <a href="logados.php">
        <button>Usuarios logados</button>
    </a>
    </div>
</body>

</html>