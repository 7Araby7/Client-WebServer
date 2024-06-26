<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha_hash = $_POST['senha'] === "" ? null : md5($_POST['senha']);
    $competencias = array();
    $experiencias = array();
    $token = $_SESSION['token'];

    if (isset($_POST['nome_empresa'])) {
        for ($i = 0; $i < count($_POST['nome_empresa']); $i++) {
            if (isset($_POST['id_Xp'][$i])) {
                $idXp = $_POST['id_Xp'][$i];
            } else {
                $idXp = null;
            }
            $experiencia = array(
                'id' => $idXp,
                'nome_empresa' => $_POST['nome_empresa'][$i],
                'inicio' => $_POST['inicio'][$i],
                'fim' => $_POST['fim'][$i],
                'cargo' => $_POST['cargo'][$i]
            );
            array_push($experiencias, $experiencia);
        }
    }

    function getNomeCompetencia($id)
    {
        if (isset($_SESSION['competenciasLista']) && is_array($_SESSION['competenciasLista'])) {
            foreach ($_SESSION['competenciasLista'] as $competencia) {
                if ($competencia['id'] == $id) {
                    return $competencia['nome'];
                }
            }
        }
        return null;
    }


    if (isset($_POST['competencias'])) {
        $competencias = array();
        for ($i = 0; $i < count($_POST['competencias']); $i++) {
            $nomeComp = getNomeCompetencia($_POST['competencias'][$i]);
            $competencia = array(
                'id' => $_POST['competencias'][$i],
                'nome' =>  $nomeComp
            );
            array_push($competencias, $competencia);
        }
    }

    $data = array(
        'nome' => $nome,
        'email' => $email,
        'senha' => $senha_hash,
        'competencias' => $competencias,
        'experiencia' => $experiencias
    );

    //echo json_encode($data);

    $url = $_SESSION['serverIP'] . "/usuario";

    $options = array(
        'http' => array(
            'method' => 'PUT',
            'header'  => "Content-Type: application/json\r\n" .
                "Authorization: Bearer $token\r\n",
            'content' => json_encode($data),
            'ignore_errors' => true
        )
    );

    $context = stream_context_create($options);

    $response = @file_get_contents($url, false, $context);

    $resultado = json_decode($response);

    //echo $resultado->mensagem;

    if ($response !== false) {
        $resultado = json_decode($response, true);

        if (isset($resultado['mensagem'])) {
            echo '<script>alert("' . $resultado['mensagem'] . '"); window.location.href = "ler_controller.php";</script>';
            exit();
        } else {
            echo "Erro: resposta inválida";
        }
    } else {
        $_SESSION['mensagem_erro'] = 'Falha na requisição ao servidor';
        $_SESSION['erro'] = true;
        header("Location: ../view/editar.php");
        exit();
    }
}
