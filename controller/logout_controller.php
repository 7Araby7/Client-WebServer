<?php
session_start();

if (isset($_POST['logout'])) {
    $token = $_POST['logout'];

    $url = $_SESSION['serverIP'] . "/logout";

    $data = json_encode(array());

    $options = array(
        'http' => array(
            'method'  => 'POST',
            'header'  => "Content-Type: application/json\r\n" .
                "Authorization: Bearer $token\r\n",
            'content' => $data
        )
    );

    $context = stream_context_create($options);

    $response = @file_get_contents($url, false, $context);

    if ($response === false) {

        $http_status = $http_response_header[0];
        if (strpos($http_status, '401 Unauthorized') !== false) {
            $_SESSION['mensagem_erro'] = 'Token não encontrado';
            $_SESSION['erro'] = true;
        } else {
            $_SESSION['mensagem_erro'] = 'Falha na requisição ao servidor';
            $_SESSION['erro'] = true;
        }
    } else {

        $_SESSION = array();
        session_destroy();
        header("Location: ../index.php");
        exit();
    }
} else {

    $_SESSION['mensagem_erro'] = 'Token não fornecido';
    $_SESSION['erro'] = true;
}

header("Location: ../view/error.php");
exit();
