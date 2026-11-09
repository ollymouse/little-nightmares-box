<?php
session_start();
if (!isset($_SESSION["idJog"])) {
    header("Location: loginusuario.php");
    exit();
}

include "conexao.php";


$sqlLoc = $sql->query("
    SELECT l.idLocal,
           l.locNome,
           l.locDesc,
           col.colNome,
           col.colTipo
    FROM local l
    LEFT JOIN colecionavel col ON col.idColecao = l.idColecao
    ORDER BY l.locNome, col.colNome
");

$locais = [];
if ($sqlLoc && $sqlLoc->num_rows > 0) {
    while ($row = $sqlLoc->fetch_assoc()) {
        $idLocal = $row["idLocal"];

        if (!isset($locais[$idLocal])) {
            $locais[$idLocal] = [
                "locNome" => $row["locNome"],
                "locDesc" => $row["locDesc"],
                "colecionaveis" => []
            ];
        }

        if ($row["colNome"]) {
            $locais[$idLocal]["colecionaveis"][] = [
                "colNome" => $row["colNome"],
                "colTipo" => $row["colTipo"]
            ];
        }
    }
}

$sql->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Locais</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/local.css">
</head>
<body>
<div class="cont">
    <header>
        <h1>Locais do jogo</h1>
        <nav>
            <a href="main.php">Início</a>
            <a href="colecionaveis.php">Colecionáveis</a>
            <a href="locais.php">Locais</a>
            <a href="logout.php">Sair</a>
        </nav>
    </header>

    <main>
        <p>Explore os locais e veja quais colecionáveis podem ser encontrados em cada um.</p>

        <?php if (count($locais) > 0): ?>
            <?php foreach ($locais as $loc): ?>
                <section style="margin-bottom: 20px;">
                    <h2><?php echo htmlspecialchars($loc["locNome"]); ?></h2>
                    <p><?php echo htmlspecialchars($loc["locDesc"]); ?></p>

                    <?php if (count($loc["colecionaveis"]) > 0): ?>
                        <h3>Colecionáveis neste local:</h3>
                        <ul>
                            <?php foreach ($loc["colecionaveis"] as $col): ?>
                                <li>
                                    <?php echo htmlspecialchars($col["colNome"]); ?>
                                    (<?php echo htmlspecialchars($col["colTipo"]); ?>)
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>Não há colecionáveis cadastrados para este local.</p>
                    <?php endif; ?>
                </section>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Não há locais cadastrados.</p>
        <?php endif; ?>
    </main>
</div>
</body>
</html>