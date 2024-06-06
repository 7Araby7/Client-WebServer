<?php
session_start();

if (!isset($_SESSION['token'])) {
    $_SESSION['mensagem_erro'] = 'Token não fornecido';
    $_SESSION['erro'] = true;
    header("Location: login.php");
    exit();
}

$id = $_POST['id'];
$token = $_SESSION['token'];
$pagina = $_POST['pagina'];

$url = $_SESSION['serverIP'] . "/vagas" . "/" . $id;

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

$vaga = json_decode($response, true);

//var_dump($vaga);

if ($vaga === null) {
    $_SESSION['mensagem_erro'] = 'Resposta não decodificada';
    $_SESSION['erro'] = true;
    header("Location: ../view/error.php");
    exit();
}elseif (isset($vaga['mensagem'])) {
    echo '<script>alert("' . $vaga['mensagem'] . '"); window.location.href = "../view/vagas.php";</script>';
    exit();
} else {
    $_SESSION['vagasLista'] = $vaga;
    if ($pagina == "vagaId") {
        header("Location: ../view/listarVagas.php");
    } else {
        header("Location: ../view/editarVaga.php");
    }
}
