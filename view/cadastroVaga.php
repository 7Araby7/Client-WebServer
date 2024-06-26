<?php
session_start();
if (!isset($_SESSION['serverIP'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Vaga</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container">
        <h2>Cadastrar Vaga</h2>
        <form action="../controller/cadastrarVaga_controller.php" method="POST">
            <p>
                <?php if (!empty($_SESSION['erro'])) : ?>
                    <?php if ($_SESSION['erro']) : ?>
            <div class="warning">
                <?php echo $_SESSION['mensagem_erro'] ?>
            </div>
        <?php endif ?>
    <?php $_SESSION['erro'] = false;
                endif ?>
    </p>
    <h3>Ramo</h3>
    <hr>
    <select name="ramo">
        <option value="" selected disabled>Selecione um ramo</option>
        <?php foreach ($_SESSION['ramosLista'] as $ramo) : ?>
            <option value="<?php echo $ramo['id']; ?>"><?php echo $ramo['nome']; ?></option>
        <?php endforeach; ?>
    </select>
    <h3>Título</h3>
    <hr>
    <input type="text" name="titulo" placeholder="Título" required>
    <h3>Descrição</h3>
    <hr>
    <textarea name="descricao" placeholder="Descrição da vaga" minlength="10" rows="4" required></textarea>
    <h3>Competências</h3>
    <div id="competencias">
    </div>
    <button type="button" onclick="addCompetencia()">Adicionar Competência</button>
    <h3>Experiência na área</h3>
    <hr>
    <input type="number" name="experiencia" placeholder="Mínimo de anos de experiência na área"required>
    <h3>Salário mínimo</h3>
    <hr>
    <input type="number" name="salario_min" placeholder="Salario mínimo" step="any" required>
    <h3>Salário máximo</h3>
    <hr>
    <input type="number" name="salario_max" placeholder="Salario máximo" step="any">
    <h3>Status da vaga</h3>
    <hr>
    <input type="radio" id="true" name="ativo" value="true">
    <label for="true">Ativa</label><br>
    <input type="radio" id="false" name="ativo" value="false">
    <label for="false">Inativa</label><br>
    <button type="submit">Cadastrar</button>
        </form>
    </div>

    <script>
        function addCompetencia() {
            var div = document.getElementById("competencias");
            var hr = document.createElement("hr");
            div.appendChild(hr);
            var select = document.createElement("select");
            select.name = "competencias[]";
            var option = document.createElement("option");
            option.value = "";
            option.text = "Selecione uma competência";
            option.selected = true;
            option.disabled = true;
            select.appendChild(option);
            <?php foreach ($_SESSION['competenciasLista'] as $comp) : ?>
                var option = document.createElement("option");
                option.value = "<?php echo $comp['id']; ?>";
                option.text = "<?php echo $comp['nome']; ?>";
                select.appendChild(option);
            <?php endforeach; ?>
            var container = document.createElement("div");
            container.appendChild(select);
            div.appendChild(container);
        }
    </script>
</body>

</html>