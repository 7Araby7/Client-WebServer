<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Usuários Logados</title>
</head>

<body>

    <?php

    $url = "http://localhost:8000/usuario/logado";

    $options = array(
        'http' => array(
            'method' => 'GET',
            'ignore_errors' => true
        )
    );

    $context = stream_context_create($options);

    $response = @file_get_contents($url, false, $context);

    if ($response === FALSE) {
        echo "Erro ao acessar a servidor.";
    } else {
        $usuarios = json_decode($response, true);
    }
    ?>
    <div class="tabela">
        <h2>Usuários Logados</h2>

        <table>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Tipo</th>
                <th>Token</th>
            </tr>
            <?php
            if (!empty($usuarios)) {
                foreach ($usuarios as $usuario) {
                    echo "<tr>";
                    echo "<td>" . ($usuario['nome']) . "</td>";
                    echo "<td>" . ($usuario['email']) . "</td>";
                    echo "<td>" . ($usuario['tipo']) . "</td>";
                    echo "<td class='token'>" . ($usuario['token']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Nenhum usuário logado.</td></tr>";
            }
            ?>
        </table>

        <div>
            <a href="index.php">
                <button>Voltar</button>
            </a>
        </div>

    </div>
</body>

</html>