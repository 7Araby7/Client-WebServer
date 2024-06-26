<?php
session_start();

if (!isset($_SESSION['token'])) {
    header("Location: login.php");
    exit();
}
if(!isset($_SESSION['candidatos']['candidatos'])){
    $candidatos = $_SESSION['candidatos'];
}else{
$candidatos = $_SESSION['candidatos']['candidatos'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container">
        <h2><?php if($_SESSION['tipo'] == "empresa"){echo "Candidatos qualificados para a vaga:";}else{echo "Perfil do Usuário";} ?></h2>
        <?php if (!empty($candidatos)) : ?>
        <form action="../controller/mensagem_controller.php" method="POST">
            <ul>
                <?php
                if (array_keys($candidatos) !== range(0, count($candidatos) - 1)) {
                    $candidatos = [$candidatos];
                }
                foreach ($candidatos as $candidato) : ?>
                <li>
                    <?php if($_SESSION['tipo'] == "empresa"): ?>
                        <input type="checkbox" name="selecionados[]" value="<?php echo $candidato['email']; ?>">
                    <?php endif; ?>
                    <p><strong>Nome:</strong> <?php echo $candidato['nome']; ?></p>
                    <p><strong>Email:</strong> <?php echo $candidato['email']; ?></p>
                    <p><strong>Tipo:</strong> <?php echo $candidato['tipo']; ?></p>

                    <h3>Competências:</h3>
                    <ul>
                        <?php foreach ($candidato['competencias'] as $competencia) : ?>
                            <li>
                                ID: <?php echo $competencia['id']; ?><br>
                                Nome: <?php echo $competencia['nome']; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <h3>Experiências:</h3>
                    <ul>
                        <?php foreach ($candidato['experiencia'] as $experiencia) : ?>
                            <li>
                                <?php echo $experiencia['nome_empresa']; ?><br>
                                Início: <?php echo $experiencia['inicio']; ?><br>
                                Fim: <?php echo $experiencia['fim']; ?><br>
                                Cargo: <?php echo $experiencia['cargo']; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <hr>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php if($_SESSION['tipo'] == "empresa"): ?>
                <button type="submit">Enviar Selecionados</button>
            <?php endif; ?>
        </form>
        <?php else : ?>
            <p>Nenhum candidato encontrado para essa vaga.</p>
        <?php endif; ?>
        <form action="<?php if($_SESSION['tipo'] == "empresa"){echo "listarVagas.php";}else{echo "perfil.php";} ?>" method="GET">
            <button type="submit">voltar</button>
        </form>
    </div>
</body>

</html>