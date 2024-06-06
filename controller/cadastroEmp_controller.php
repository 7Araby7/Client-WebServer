<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['ramo']) && isset($_POST['descricao'])) {

        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $senha_hash = md5($senha);
        $ramo = $_POST['ramo'];
        $descricao = $_POST['descricao'];

        $data = json_encode(array(
            'nome' => $nome,
            'email' => $email,
            'senha' => $senha_hash,
            'ramo' => $ramo,
            'descricao' => $descricao
        ));

        $url = $_SESSION['serverIP'] . "/usuarios/empresa";

        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type: application/json',
                'content' => $data,
                'ignore_errors' => true
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
            $_SESSION['mensagem_erro'] = 'Falha na requisição ao servidor';
            $_SESSION['erro'] = true;
            header("Location: ../view/cadastroEmp.php");
            exit();
        }
    } else {
        echo "Todos os campos devem ser preenchidos";
    }
}
