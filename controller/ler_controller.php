<?php
session_start();

if (!isset($_SESSION['token'])) {
    $_SESSION['mensagem_erro'] = 'Token não fornecido';
    $_SESSION['erro'] = true;
    header("Location: login.php");
    exit();
}

$pagina = $_POST['pagina'];
$token = $_SESSION['token'];

$url = $url = $_SESSION['serverIP'] . "/usuario";

$options = array(
    'http' => array(
        'method' => 'GET',
        'header' => "Authorization: Bearer $token\r\n"
    )
);

$context = stream_context_create($options);

$response = @file_get_contents($url, false, $context);

if ($response === false) {

    $http_status = $http_response_header[0];
    if (strpos($http_status, '401 Unauthorized') !== false) {
        $_SESSION['mensagem_erro'] = 'Token inválido';
        $_SESSION['erro'] = true;
        header("Location: ../view/error.php");
        exit();
    } else {

        $_SESSION['mensagem_erro'] = 'Erro ao obter dados do usuário';
        $_SESSION['erro'] = true;
        header("Location: ../view/error.php");
        exit();
    }
}

$dados_usuario = json_decode($response, true);



if ($dados_usuario === null) {

    $_SESSION['mensagem_erro'] = 'Resposta não decodificada';
    $_SESSION['erro'] = true;
    header("Location: ../view/error.php");
    exit();
}

if ($dados_usuario['tipo'] === 'empresa') {

    $_SESSION['nome_empresa'] = $dados_usuario['nome'];
    $_SESSION['email_empresa'] = $dados_usuario['email'];
    $_SESSION['ramo'] = $dados_usuario['ramo'];
    $_SESSION['descricao'] = $dados_usuario['descricao'];
    if ($pagina === 'lista') {
        header("Location: ../view/listaEmp.php");
    } else {
        header("Location: ../view/editarEmp.php");
    }
    exit();
} else {

    if ($pagina === 'editar') {

        $url = $url = $_SESSION['serverIP'] . "/competencias";

        $options = array(
            'http' => array(
                'method' => 'GET',
                'header' => "Authorization: Bearer $token\r\n"
            )
        );

        $context = stream_context_create($options);

        $response = @file_get_contents($url, false, $context);

        if ($response === false) {

            $http_status = $http_response_header[0];
            if (strpos($http_status, '401 Unauthorized') !== false) {
                $_SESSION['mensagem_erro'] = 'Token inválido';
                $_SESSION['erro'] = true;
                header("Location: ../view/error.php");
                exit();
            } else {

                $_SESSION['mensagem_erro'] = 'Erro ao obter dados das competencias';
                $_SESSION['erro'] = true;
                header("Location: ../view/error.php");
                exit();
            }
        }

        $competencias = json_decode($response, true);
        
        if ($competencias === null) {
            
            $_SESSION['mensagem_erro'] = 'Resposta não decodificada';
            $_SESSION['erro'] = true;
            header("Location: ../view/error.php");
            exit();
        }else{
            $_SESSION['competenciasLista'] = $competencias;
        }
    }
    $_SESSION['nome'] = $dados_usuario['nome'];
    $_SESSION['email'] = $dados_usuario['email'];
    $_SESSION['tipo'] = $dados_usuario['tipo'];
    $_SESSION['competencias'] = $dados_usuario['competencias'];
    $_SESSION['experiencia'] = $dados_usuario['experiencia'];
    if ($pagina === 'lista') {
        header("Location: ../view/lista.php");
    } else {
        header("Location: ../view/editar.php");
    }
    exit();
}
