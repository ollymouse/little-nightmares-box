<?php
session_start();
if (!isset($_SESSION["idJog"])) {
    header("Location: loginusuario.php");
    exit();
}

include "conexao.php";

if (!isset($_GET["idColecao"])) {
    header("Location: colecionaveis.php");
    exit();
}

$idColecao = (int)$_GET["idColecao"];

// dados do colecionável
$stmtCol = $sql->prepare("
    SELECT idColecao, colNome, colTipo, colLocal
    FROM colecionavel
    WHERE idColecao = ?
");
$stmtCol->bind_param("i", $idColecao);
$stmtCol->execute();
$resultCol = $stmtCol->get_result();
$colecionavel = $resultCol->fetch_assoc();
$stmtCol->close();

if (!$colecionavel) {
    $sql->close();
    die("Colecionável não encontrado.");
}

// locais onde aparece
$stmtLoc = $sql->prepare("
    SELECT l.locNome, l.locDesc
    FROM local l
    WHERE l.idColecao = ?
");
$stmtLoc->bind_param("i", $idColecao);
$stmtLoc->execute();
$resultLoc = $stmtLoc->get_result();

$locais = [];
while ($row = $resultLoc->fetch_assoc()) {
    $locais[] = $row;
}
$stmtLoc->close();

$sql->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Detalhe do colecionável</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="cont">
    <header>
        <h1>Detalhe do colecionável</h1>
        <nav>
            <a href="main.php">Início</a>
            <a href="colecionaveis.php">Colecionáveis</a>
            <a href="locais.php">Locais</a>
            <a href="logout.php">Sair</a>
        </nav>
    </header>

    <main>
        <section>
            <h2><?php echo htmlspecialchars($colecionavel["colNome"]); ?></h2>
            <p><strong>Tipo:</strong> <?php echo htmlspecialchars($colecionavel["colTipo"]); ?></p>
            <p><strong>Descrição/Local (texto do item):</strong> <?php echo htmlspecialchars($colecionavel["colLocal"]); ?></p>
        </section>

        <section>
            <h3>Locais onde pode ser encontrado</h3>
            <?php if (count($locais) > 0): ?>
                <ul>
                    <?php foreach ($locais as $loc): ?>
                        <li>
                            <strong><?php echo htmlspecialchars($loc["locNome"]); ?></strong> —
                            <?php echo htmlspecialchars($loc["locDesc"]); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Nenhum local específico cadastrado para este colecionável.</p>
            <?php endif; ?>
        </section>

        <p><a href="colecionaveis.php">Voltar à lista de colecionáveis</a></p>
    </main>
</div>
</body>
</html>
