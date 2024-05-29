<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $ramo = $_POST['ramo'];
    $descricao = $_POST['descricao'];
    $token = $_SESSION['token'];

    if($_POST['senha'] === ""){
        $senha_hash = null;
    }else{
        $senha_hash = md5($senha);
    }

    $data = array(
        'nome' => $nome,
        'email' => $email,
        'senha' => $senha_hash,
        'ramo' => $ramo,
        'descricao' => $descricao
    );

    //echo json_encode($data);

    $url = $_SESSION['serverIP'] . "/usuario";

    $options = array(
        'http' => array(
            'method' => 'PUT',
            'header'  => "Content-Type: application/json\r\n" .
                "Authorization: Bearer $token\r\n",
            'content' => json_encode($data)
        )
    );

    $context = stream_context_create($options);

    $response = @file_get_contents($url, false, $context);

    $resultado = json_decode($response);

    //echo $resultado->mensagem;

    if ($response !== false) {
        $resultado = json_decode($response, true);

        if (isset($resultado['mensagem'])) {
            echo '<script>alert("' . $resultado['mensagem'] . '"); window.location.href = "../view/perfil.php";</script>';
            exit();
        } else {
            echo "Erro: resposta inválida";
        }
    } else {
        $http_status = $http_response_header[0];
        if (strpos($http_status, '401 Unauthorized') !== false) {
            $_SESSION['mensagem_erro'] = 'E-mail já cadastrado';
            $_SESSION['erro'] = true;
            header("Location: ../view/editarEmp.php");
            exit();
        } else {
            $_SESSION['mensagem_erro'] = 'Falha na requisição ao servidor';
            $_SESSION['erro'] = true;
            header("Location: ../view/editarEmp.php");
            exit();
        }
    } 
}
