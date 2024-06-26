<?php
session_start();

if (!isset($_SESSION['token'])) {
    $_SESSION['mensagem_erro'] = 'Token não fornecido';
    $_SESSION['erro'] = true;
    header("Location: login.php");
    exit();
}

$token = $_SESSION['token'];

//---------------------------------------------------------
$url = $url = $_SESSION['serverIP'] . "/usuario";

$options = array(
    'http' => array(
        'method' => 'GET',
        'header' => "Authorization: Bearer $token\r\n",
        'ignore_errors' => true
    )
);

$context = stream_context_create($options);

$response = @file_get_contents($url, false, $context);

if ($response === false) {
    $_SESSION['mensagem_erro'] = 'Erro ao obter dados do usuário';
    $_SESSION['erro'] = true;
    header("Location: ../view/error.php");
    exit();
}

$dados_usuario = json_decode($response, true);

//---------------------------------------------------------
$url = $_SESSION['serverIP'] . "/competencias";

$options = array(
    'http' => array(
        'method' => 'GET',
        'header' => "Authorization: Bearer $token\r\n",
        'ignore_errors' => true
    )
);

$context = stream_context_create($options);

$response = @file_get_contents($url, false, $context);

if ($response === false) {
    $_SESSION['mensagem_erro'] = 'Erro ao obter dados das competencias';
    $_SESSION['erro'] = true;
    header("Location: ../view/error.php");
    exit();
}

$competencias = json_decode($response, true);
//---------------------------------------------------------

if ($competencias === null) {
    $_SESSION['mensagem_erro'] = 'Resposta não decodificada';
    $_SESSION['erro'] = true;
    header("Location: ../view/error.php");
    exit();
} elseif (isset($competencias['mensagem'])) {
    $_SESSION['mensagem_erro'] = $competencias['mensagem'];
    $_SESSION['erro'] = true;
    header("Location: ../view/error.php");
    exit();
} else {
    $_SESSION['competenciasLista'] = $competencias;
}

if ($dados_usuario === null) {
    $_SESSION['mensagem_erro'] = 'Resposta dos dados do usuarionão decodificada';
    $_SESSION['erro'] = true;
    header("Location: ../view/error.php");
    exit();
}elseif (isset($dados_usuario['mensagem'])) {
    $_SESSION['mensagem_erro'] = $dados_usuario['mensagem'];
    $_SESSION['erro'] = true;
    header("Location: ../view/error.php");
    exit();
}

if ($dados_usuario['tipo'] === 'empresa') {

    $_SESSION['empresa'] = $dados_usuario;
    $_SESSION['tipo'] = $dados_usuario['tipo'];
    header("Location: ../view/perfil.php");
    exit();
} else {

    $_SESSION['candidatos'] = $dados_usuario;
    $_SESSION['tipo'] = $dados_usuario['tipo'];
    header("Location: lerMensagem_controller.php");
    exit();
}
