<?php
session_start();

if (!isset($_SESSION['token'])) {
    $_SESSION['mensagem_erro'] = 'Token não fornecido';
    $_SESSION['erro'] = true;
    header("Location: login.php");
    exit();
}

$token = $_SESSION['token'];

$url = $url = $_SESSION['serverIP'] . "/vagas";

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
    $_SESSION['mensagem_erro'] = 'Erro ao obter dados das vagas';
    $_SESSION['erro'] = true;
    header("Location: ../view/error.php");
    exit();
}

$vagas = json_decode($response, true);

if ($vagas === null) {
    $_SESSION['mensagem_erro'] = 'Resposta não decodificada';
    $_SESSION['erro'] = true;
    header("Location: ../view/error.php");
    exit();
}elseif (isset($vagas['mensagem'])) {
    echo '<script>alert("' . $vagas['mensagem'] . '"); window.location.href = "../view/vagas.php";</script>';
    exit();
} else {
    $_SESSION['vagasLista'] = $vagas;
    header("Location: ../view/listarVagas.php");
}
