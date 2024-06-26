<?php
session_start();

if (!isset($_SESSION['token'])) {
    $_SESSION['mensagem_erro'] = 'Token não fornecido';
    $_SESSION['erro'] = true;
    header("Location: login.php");
    exit();
}

$token = $_SESSION['token'];

$url = $url = $_SESSION['serverIP'] . "/mensagem";

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
    $_SESSION['mensagem_erro'] = 'Erro ao obter dados dos ramos';
    $_SESSION['erro'] = true;
    echo 'salveee';
    header("Location: ../view/error.php");
    exit();
}

$mensagens = json_decode($response, true);

var_dump($mensagens);

if ($mensagens === null) {

    header("Location: ../view/perfil.php");
    exit();
}

$_SESSION['mensagens'] = array_reverse($mensagens);


if (array_keys($mensagens) !== range(0, count($mensagens) - 1)) {
    $mensagens = [$mensagens];
}
foreach ($mensagens as $mensagem) {
    if($mensagem['lida'] == false){
        $statusClass = "ativo";
    }
}

$_SESSION['novaMensagem'] = $statusClass;

header("Location: ../view/perfil.php");
