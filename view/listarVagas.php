<?php
session_start();

if (!isset($_SESSION['token'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['vagasLista'])) {
    $_SESSION['mensagem_erro'] = 'Nenhuma vaga encontrada';
    $_SESSION['erro'] = true;
    header("Location: error.php");
    exit();
}

$vagas = $_SESSION['vagasLista'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Vagas</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container">
        <h2>Lista de Vagas <?php if($_SESSION['tipo'] == "empresa"){echo $_SESSION['empresa']['nome'];}else{echo "Disponíveis";} ?></h2>
        <?php if (!empty($vagas)) : ?>
            <ul>
                <?php
                if (array_keys($vagas) !== range(0, count($vagas) - 1)) {
                    $vagas = [$vagas];
                }
                foreach ($vagas as $vaga) :
                    $statusClass = $vaga['ativo'] ? 'ativo' : 'inativo';
                ?>
                    <li class="<?php echo $statusClass; ?>">
                        <h2><?php echo htmlspecialchars($vaga['titulo']); ?></h2>
                        <div class="ramo">
                            <p><strong>Ramo:</strong><?php echo $vaga['ramo']/* [0] */['nome']; ?></p>
                            <p><?php echo $vaga['ramo']/* [0] */['descricao']; ?></p>
                        </div>
                        <p><strong>Descrição:</strong> <?php echo htmlspecialchars($vaga['descricao']); ?></p>
                        <p><strong>Experiência:</strong> <?php echo $vaga['experiencia']; ?> anos</p>
                        <p><strong>Salário Mínimo:</strong> R$ <?php echo number_format($vaga['salario_min'], 2, ',', '.'); ?></p>
                        <?php if ($vaga['salario_max'] != null) : ?>
                            <p><strong>Salário Máximo:</strong> R$ <?php echo number_format($vaga['salario_max'], 2, ',', '.'); ?></p>
                        <?php endif; ?>
                        <p><strong>Status:</strong> <?php echo $vaga['ativo'] ? 'Ativa' : 'Inativa'; ?></p>
                        <p><strong>Empresa ID:</strong> <?php echo $vaga['empresa_id']; ?></p>
                        <p><strong>ID:</strong> <?php echo $vaga['id']; ?></p>
                        <h4>Competências requeridas:</h4>
                        <ul>
                            <?php foreach ($vaga['competencias'] as $competencia) : ?>
                                <li>ID: <?php echo $competencia['id']; ?> - <?php echo htmlspecialchars($competencia['nome']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <?php if($_SESSION['tipo'] == 'empresa'): ?>
                            <form action="../controller/buscarVaga_controller.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $vaga['id']; ?>">
                                <button id="vagas" type="submit">Editar Vaga</button>
                            </form>
                            <form action="../controller/deleteVaga_controller.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $vaga['id']; ?>">
                                <button type="submit" onclick="return confirm('Tem certeza que deseja excluir sua esta?\n\tEssa ação não é reversível')">Excluir vaga</button>
                            </form>
                            <form action="../controller/buscarCandidato_controller.php" method="POST">
                                <?php foreach ($vaga['competencias'] as $competencia) : ?>
                                    <input type="hidden" name="competencias[]" value="<?php echo $competencia['id']; ?>">
                                <?php endforeach; ?>
                                <button id="vagas" type="submit">Buscar candidatos qualificados</button>
                            </form>

                        <?php endif; ?>
                    </li>
                    <hr>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p>Nenhuma vaga encontrada.</p>
        <?php endif; ?>
        <form action="<?php if($_SESSION['tipo'] == "empresa"){echo "vagas.php";}else{echo "perfil.php";} ?>" method="GET">
            <button type="submit">Voltar</button>
        </form>
    </div>
</body>

</html>