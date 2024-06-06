<?php
session_start();

if (!isset($_SESSION['token'])) {
    $_SESSION['mensagem_erro'] = 'Token não fornecido';
    $_SESSION['erro'] = true;
    header("Location: login.php");
    exit();
}

$token = $_SESSION['token'];

$url = $url = $_SESSION['serverIP'] . "/ramos";

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
    header("Location: ../view/error.php");
    exit();
}

$ramos = json_decode($response, true);

if ($ramos === null) {
    $_SESSION['mensagem_erro'] = 'Resposta não decodificada';
    $_SESSION['erro'] = true;
    header("Location: ../view/error.php");
    exit();
}elseif (isset($ramos['mensagem'])) {
    $_SESSION['mensagem_erro'] = $ramos['mensagem'];
    $_SESSION['erro'] = true;
    header("Location: ../view/error.php");
    exit();
} else {
    $_SESSION['ramosLista'] = $ramos;
    header("Location: ../view/vagas.php");
}
