<?php
session_start();
if (!isset($_SESSION["idJog"])) {
    header("Location: loginusuario.php");
    exit();
}

include "conexao.php";

$msgErro = "";
$msgSucesso = "";

// envio do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idCap = isset($_POST["idCap"]) ? (int)$_POST["idCap"] : 0;
    $idColecao = isset($_POST["idColecao"]) ? (int)$_POST["idColecao"] : 0;

    if ($idCap <= 0 || $idColecao <= 0) {
        $msgErro = "Selecione um capítulo e um item colecionável.";
    } else {
        $stmt = $sql->prepare("
            INSERT INTO progresso (progDataConclusao, idColecao, idCap)
            VALUES (NULL, ?, ?)
        ");
        $stmt->bind_param("ii", $idColecao, $idCap);

        if ($stmt->execute()) {
            $idNovoProg = $stmt->insert_id;

            // vincula ao jogador logado usando jogador.idProg
            $idJog = $_SESSION["idJog"];
            $stmtJog = $sql->prepare("UPDATE jogador SET idProg = ? WHERE idJog = ?");
            $stmtJog->bind_param("ii", $idNovoProg, $idJog);
            $stmtJog->execute();
            $stmtJog->close();

            $msgSucesso = "Novo progresso iniciado e vinculado ao seu usuário!";
        } else {
            $msgErro = "Erro ao iniciar progresso: " . $stmt->error;
        }

        $stmt->close();
    }
}

// carregar capítulos
$capitulos = [];
$resCap = $sql->query("SELECT idCap, capNome FROM capitulo ORDER BY capNome");
if ($resCap && $resCap->num_rows > 0) {
    while ($row = $resCap->fetch_assoc()) {
        $capitulos[] = $row;
    }
}

// carregar colecionáveis
$colecionaveis = [];
$resCol = $sql->query("SELECT idColecao, colNome FROM colecionavel ORDER BY colNome");
if ($resCol && $resCol->num_rows > 0) {
    while ($row = $resCol->fetch_assoc()) {
        $colecionaveis[] = $row;
    }
}

$sql->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo Progresso</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="cont">
    <header>
        <h1>Começar novo progresso</h1>
        <nav>
            <a href="main.php">Início</a>
            <a href="colecionaveis.php">Colecionáveis</a>
            <a href="locais.php">Locais</a>
            <a href="logout.php">Sair</a>
        </nav>
    </header>

    <main>
        <p>Escolha um capítulo e um item colecionável para registrar um novo avanço.</p>

        <?php if (!empty($msgErro)): ?>
            <div style="color: red; margin-bottom: 10px;">
                <?php echo $msgErro; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($msgSucesso)): ?>
            <div style="color: green; margin-bottom: 10px;">
                <?php echo $msgSucesso; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div>
                <label for="idCap">Capítulo:</label>
                <select name="idCap" id="idCap" required>
                    <option value="">Selecione um capítulo</option>
                    <?php foreach ($capitulos as $cap): ?>
                        <option value="<?php echo $cap["idCap"]; ?>">
                            <?php echo htmlspecialchars($cap["capNome"]); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label for="idColecao">Item colecionável:</label>
                <select name="idColecao" id="idColecao" required>
                    <option value="">Selecione um item</option>
                    <?php foreach ($colecionaveis as $col): ?>
                        <option value="<?php echo $col["idColecao"]; ?>">
                            <?php echo htmlspecialchars($col["colNome"]); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit">Iniciar</button>
        </form>

        <p><a href="main.php">Voltar para a página principal</a></p>
    </main>
</div>
</body>
</html>
