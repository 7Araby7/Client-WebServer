<?php
session_start();

if (!isset($_SESSION['token'])) {
    $_SESSION['mensagem_erro'] = 'Token não fornecido';
    $_SESSION['erro'] = true;
    header("Location: login.php");
    exit();
}

$competencias = array();
$token = $_SESSION['token'];


$competencias = array();
for ($i = 0; $i < count($_POST['competencias']); $i++) {
    $competencia = array(
        'id' => $_POST['competencias'][$i],
    );
    array_push($competencias, $competencia);
}

$data = array(
    'competencias' => $competencias
);

echo json_encode($data);

$url = $_SESSION['serverIP'] . "/usuarios/candidatos/buscar";

$options = array(
    'http' => array(
        'method' => 'POST',
        'content' => json_encode($data),
        'header' => "Content-Type: application/json\r\n" . 
        "Authorization: Bearer $token\r\n",
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

$candidato = json_decode($response, true);

//var_dump($candidato);

if ($candidato === null) {
    $_SESSION['mensagem_erro'] = 'Resposta não decodificada';
    $_SESSION['erro'] = true;
    header("Location: ../view/error.php");
    exit();
} elseif (isset($candidato['mensagem'])) {
    echo '<script>alert("' . $candidato['mensagem'] . '"); window.location.href = "../view/vagas.php";</script>';
    exit();
} else {
    $_SESSION['candidatos'] = $candidato;
    header("Location: ../view/lista.php");
}
