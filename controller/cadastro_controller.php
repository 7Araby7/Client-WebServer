<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha'])) {

        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $senha_hash = md5($senha);

        $data = json_encode(array(
            'nome' => $nome,
            'email' => $email,
            'senha' => $senha_hash
        ));

        $url = $_SESSION['serverIP'] . "/usuarios/candidatos";

        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type: application/json',
                'content' => $data
            )
        );

        $context = stream_context_create($options);

        $response = @file_get_contents($url, false, $context);

        if ($response !== false) {

            $resultado = json_decode($response, true);

            if (isset($resultado['mensagem'])) {

                echo '<script>alert("' . $resultado['mensagem'] . '"); window.location.href = "../view/login.php";</script>';
                exit();
            } else {
                echo "Erro: resposta inválida";
            }
        } else {
            $http_status = $http_response_header[0];
            if (strpos($http_status, '422 Unprocessable Content') !== false) {
                $_SESSION['mensagem_erro'] = 'E-mail já cadastrado';
                $_SESSION['erro'] = true;
                header("Location: ../view/cadastro.php");
                exit();
            }else {
                $_SESSION['mensagem_erro'] = 'Falha na requisição ao servidor';
                $_SESSION['erro'] = true;
                header("Location: ../view/cadastro.php");
                exit();
            }
        }
    } else {
        echo "Todos os campos devem ser preenchidos";
    }
}
?>
