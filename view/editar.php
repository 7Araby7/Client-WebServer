<?php
session_start();
if (!isset($_SESSION['serverIP'])) {
    header("Location: ../index.php");
    exit();
}
$candidato = $_SESSION['candidatos'];
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Usuário</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container">
        <h2>Alterar Usuário</h2>
        <form action="../controller/editar_controller.php" method="POST">
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
    <h3>Nome</h3>
    <hr>
    <input type="text" name="nome" placeholder="Nome" value="<?php echo $candidato['nome']; ?>" required>
    <h3>Email</h3>
    <hr>
    <input type="email" name="email" placeholder="Email" value="<?php echo $candidato['email']; ?>" required>
    <h3>Senha</h3>
    <hr>
    <input type="password" name="senha" placeholder="Senha" minlength="8">
    <h3>Competências</h3>
    <div id="competencias">
        <?php foreach ($candidato['competencias'] as $index => $competencia) : ?>
            <hr>
            <div id="comp-<?php echo $index; ?>">
                <select name="competencias[]">
                    <?php foreach ($_SESSION['competenciasLista'] as $comp) : ?>
                        <option value="<?php echo $comp['id']; ?>" <?php echo ($competencia['id'] == $comp['id']) ? 'selected' : ''; ?>><?php echo $comp['nome']; ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="button" onclick="deleteComp('comp-<?php echo $index; ?>')">Excluir</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" onclick="addCompetencia()">Adicionar Nova Competência</button>

    <h3>Experiências</h3>
    <div id="experiencias">
        <?php foreach ($candidato['experiencia'] as $index => $experiencia) : ?>
            <div id="xp-<?php echo $index; ?>">
                <hr>
                <input type="hidden" name="id_Xp[]" value="<?php echo $experiencia['id']; ?>">
                <input type="text" name="nome_empresa[]" placeholder="Nome da Empresa" value="<?php echo $experiencia['nome_empresa']; ?>">
                <input type="date" name="inicio[]" placeholder="Início" value="<?php echo $experiencia['inicio']; ?>">
                <input type="date" name="fim[]" placeholder="Fim" value="<?php echo $experiencia['fim']; ?>">
                <input type="text" name="cargo[]" placeholder="Cargo" value="<?php echo $experiencia['cargo']; ?>">
                <button type="button" onclick="deleteXp('xp-<?php echo $index; ?>')">Excluir</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" onclick="addExperiencia()">Adicionar Nova Experiência</button>
    <button type="submit">Alterar</button>
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
            var button = document.createElement("button");
            button.type = "button";
            button.textContent = "Excluir";
            button.onclick = function() {
                deleteComp(container);
            };
            container.appendChild(select);
            container.appendChild(button);
            div.appendChild(container);
        }

        function addExperiencia() {
            var div = document.getElementById("experiencias");
            var hr = document.createElement("hr");
            div.appendChild(hr);
            var container = document.createElement("div");
            var inputs = ["nome_empresa", "inicio", "fim", "cargo"];
            inputs.forEach(function(name) {
                var input = document.createElement("input");
                if (name === "inicio" || name === "fim") {
                    input.type = "date";
                } else {
                    input.type = "text";
                }
                input.name = name + "[]";
                input.placeholder = name.charAt(0).toUpperCase() + name.slice(1).replace('_', ' ');
                container.appendChild(input);
            });
            var button = document.createElement("button");
            button.type = "button";
            button.textContent = "Excluir";
            button.onclick = function() {
                deleteXp(container);
            };
            container.appendChild(button);
            div.appendChild(container);
        }

        function deleteComp(id) {
            var elem = document.getElementById(id);
            elem.parentNode.removeChild(elem);
        }

        function deleteXp(id) {
            var elem = document.getElementById(id);
            elem.parentNode.removeChild(elem);
        }
    </script>
</body>

</html>
