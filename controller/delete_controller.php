<?php
session_start();

if (isset($_POST['delete'])) {
    $token = $_POST['delete'];

    $url = $_SESSION['serverIP'] . "/usuario";

    $data = json_encode(array());

    $options = array(
        'http' => array(
            'method'  => 'DELETE',
            'header'  => "Content-Type: application/json\r\n" .
                "Authorization: Bearer $token\r\n",
            'content' => $data,
            'ignore_errors' => true
        )
    );

    $context = stream_context_create($options);

    $response = @file_get_contents($url, false, $context);

    if ($response === false) {
            $_SESSION['mensagem_erro'] = 'Falha na requisição ao servidor';
            $_SESSION['erro'] = true;
    } else {

        $_SESSION = array();
        session_destroy();
        $resultado = json_decode($response, true);
        echo '<script>alert("' . $resultado['mensagem'] . '"); window.location.href = "../index.php";</script>';
        exit();
    }
} else {
    $_SESSION['mensagem_erro'] = 'Token não fornecido';
    $_SESSION['erro'] = true;
}

header("Location: ../view/error.php");
exit();
