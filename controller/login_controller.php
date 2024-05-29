<?php
session_start();

if (!isset($_POST['email']) || !isset($_POST['senha'])) {

    $_SESSION['erro'] = true;
    $_SESSION['mensagem_erro'] = 'email ou senha não inseridos';
    header("Location: ../view/login.php");
    exit();
}

$email = $_POST['email'];
$senha = $_POST['senha'];
$senha_hash = md5($senha);


if (!isset($_SESSION['serverIP'])) {

    $_SESSION['mensagem_erro'] = 'Erro na conexão com o servidor';
    $_SESSION['erro'] = true;
    header("Location: ../index.php");
    exit();
}

$url = $_SESSION['serverIP'] . "/login";

$data = json_encode(array('email' => $email, 'senha' => $senha_hash));

$options = array(
    'http' => array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/json',
        'content' => $data,
    )
);


$context  = stream_context_create($options);

$response = file_get_contents($url, false, $context);

if ($response === false) {
    $http_status = $http_response_header[0];
    if (strpos($http_status, '401 Unauthorized') !== false) {
        $_SESSION['mensagem_erro'] = 'E-mail ou senha incorretos';
        $_SESSION['erro'] = true;
        header("Location: ../view/login.php");
        exit();
    } elseif (strpos($http_status, '422 Unprocessable Content') !== false) {
        $_SESSION['mensagem_erro'] = 'Erro no formato dos dados';
        $_SESSION['erro'] = true;
        header("Location: ../view/login.php");
        exit();
    } else {
        $_SESSION['mensagem_erro'] = 'Falha na requisição ao servidor';
        $_SESSION['erro'] = true;
        header("Location: ../view/login.php");
        exit();
    }
}

$resultado = json_decode($response);

if ($resultado === null) {
    $_SESSION['mensagem_erro'] = 'Resposta não decodificada';
    $_SESSION['erro'] = true;
    header("Location: ../view/login.php");
    exit();
}

if (isset($resultado->mensagem)) {
    $_SESSION['erro'] = true;
    $_SESSION['mensagem_erro'] = $resultado->mensagem;
    header("Location: login.php");
    exit();
} elseif (isset($resultado->token)) {

    $_SESSION['token'] = $resultado->token;
    echo $_SESSION['token'];
    header("Location: ../view/perfil.php");
    exit();
} else {

    $_SESSION['erro'] = true;
    $_SESSION['mensagem_erro'] = 'Erro na conexão com o servidor';
    header("Location: ../view/login.php");
    exit();
}
