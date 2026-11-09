<?php

session_start();
if (!isset($_SESSION["idJog"])) {
    header("Location: loginusuario.php");
    exit();
}

include "conexao.php";

$sqlCole = $sql->query("
    SELECT col.idColecao,
           col.colNome,
           col.colTipo,
           col.colLocal,
           l.locNome
    FROM colecionavel col
    LEFT JOIN local l ON l.idColecao = col.idColecao
    ORDER BY col.colNome, l.locNome
");

$colecionaveis = [];
if ($sqlCole && $sqlCole->num_rows > 0) {
    while ($row = $sqlCole->fetch_assoc()) {
        $colecionaveis[] = $row;
    }
}

$sql->close();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Colecionáveis</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/colecionavel.css">
</head>
<body>
<div class="cont">

    <div id="logo"></div>

    <div id="cabeçalho">
        <h1>Colecionáveis de Little Nightmares</h1>

        <nav>
            <a href="main.php">Início</a>
            <a href="colecionaveis.php">Colecionáveis</a>
            <a href="locais.php">Locais</a>
            <a href="logout.php">Sair</a>
        </nav>
    </div>

    <main>
        <p>Aqui você vê os itens colecionáveis, seus tipos e onde podem ser encontrados.</p>

        <?php if (count($colecionaveis) > 0): ?>
            <table style="
            width: 100%;
            border: 6px solid #c8b566;
            border-collapse: collapse;
            font-size: 5vh;
            text-align: left;
            margin-top: 20px;
            color: white;
        ">
            <thead>
                <tr>
                    <th style="border: 2px solid #c8b566; padding: 10px;">Nome do item</th>
                    <th style="border: 2px solid #c8b566; padding: 10px;">Tipo</th>
                    <th style="border: 2px solid #c8b566; padding: 10px;">Descrição do local</th>
                    <th style="border: 2px solid #c8b566; padding: 10px;">Nome do local</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($colecionaveis as $col): ?>
                    <tr>
                        <td style="border: 2px solid #c8b566; padding: 10px;">
                            <a href="detalhe_colecionavel.php?idColecao=<?php echo $col['idColecao']; ?>"
                               style="color: white; text-decoration: none;">
                                <?php echo htmlspecialchars($col["colNome"]); ?>
                            </a>
                        </td>

                        <td style="border: 2px solid #c8b566; padding: 10px;">
                            <?php echo htmlspecialchars($col["colTipo"]); ?>
                        </td>

                        <td style="border: 2px solid #c8b566; padding: 10px;">
                            <?php echo htmlspecialchars($col["colLocal"]); ?>
                        </td>

                        <td style="border: 2px solid #c8b566; padding: 10px;">
                            <?php
                                echo $col["locNome"]
                                    ? htmlspecialchars($col["locNome"])
                                    : "Sem local cadastrado";
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else: ?>
        <p style="text-align: center; font-size: 30px;">Não há colecionáveis cadastrados.</p>
    <?php endif; ?>

    </main>
</div>
</body>
</html>
