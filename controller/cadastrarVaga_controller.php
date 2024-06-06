<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $ramo = $_POST['ramo'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $experiencia = $_POST['experiencia'];
    $salario_min = $_POST['salario_min'];
    $salario_max = $_POST['salario_max'];
    $ativo = $_POST['ativo'] === 'true' ? true : false;
    $competencias = array();
    $token = $_SESSION['token'];

    if ($_POST['salario_max'] === "") {
        $max = null;
    } else {
        $max = (int)$_POST['salario_max'];
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
        'ramo_id' => (int)$ramo,
        'titulo' => $titulo,
        'descricao' => $descricao,
        'competencias' => $competencias,
        'experiencia' => (int)$experiencia,
        'salario_min' => (int)$salario_min,
        'salario_max' => $max,
        'ativo' => $ativo
    );

    echo json_encode($data);

    echo $_SESSION['token'];

    $url = $_SESSION['serverIP'] . "/vagas";

    $options = array(
        'http' => array(
            'method' => 'POST',
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
            echo '<script>alert("' . $resultado['mensagem'] . '"); window.location.href = "../view/vagas.php";</script>';
            exit();
        } else {
            echo "Erro: resposta inválida";
        }
    } else {
        $_SESSION['mensagem_erro'] = 'Falha na requisição ao servidor';
        $_SESSION['erro'] = true;
        header("Location: ../view/cadastroVaga.php");
        exit();
    }
}
