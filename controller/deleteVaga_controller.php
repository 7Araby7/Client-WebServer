<?php
session_start();

if (isset($_POST['id'])) {


    $id = $_POST['id'];
    $token = $_SESSION['token'];

    $url = $_SESSION['serverIP'] . "/vagas". "/" . $id;

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
        $resultado = json_decode($response, true);
        echo '<script>alert("' . $resultado['mensagem'] . '"); window.location.href = "../view/vagas.php";</script>';
        exit();
    }
} else {
    $_SESSION['mensagem_erro'] = 'Id não fornecido';
    $_SESSION['erro'] = true;
}

header("Location: ../view/error.php");
exit();
