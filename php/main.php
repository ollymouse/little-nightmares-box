<?php
session_start();
if (!isset($_SESSION["idJog"])) {
    header("Location: loginusuario.php");
    exit();
}

include "conexao.php";

$apelido = $_SESSION["apelido"];

$sqlAtual = $sql->query("
    SELECT p.idProg, p.progDataConclusao, c.capNome, col.colNome
    FROM progresso p
    INNER JOIN capitulo c ON p.idCap = c.idCap
    INNER JOIN colecionavel col ON p.idColecao = col.idColecao
    WHERE p.progDataConclusao IS NULL
    ORDER BY p.idProg DESC
    LIMIT 1
");

$progressoAtual = $sqlAtual ? $sqlAtual->fetch_assoc() : null;

$sqlAntigos = $sql->query("
    SELECT p.idProg,
           p.progDataConclusao,
           c.capNome,
           col.colNome,
           j.jogApel
    FROM progresso p
    INNER JOIN capitulo c ON p.idCap = c.idCap
    INNER JOIN colecionavel col ON p.idColecao = col.idColecao
    LEFT JOIN jogador j ON j.idProg = p.idProg
    WHERE p.progDataConclusao IS NOT NULL
    ORDER BY p.progDataConclusao DESC, p.idProg DESC
");

$progressoAntigos = [];
if ($sqlAntigos) {
    while ($row = $sqlAntigos->fetch_assoc()) {
        $progressoAntigos[] = $row;
    }
}

$sql->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Little Nightmares Box</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="cont">
    <div id="logo"></div>

    <header>
        <h1>Olá, <?php echo htmlspecialchars($apelido); ?>! 𖠁</h1>

        <nav>
            <a href="main.php">Início</a>
            <a href="colecionaveis.php">Colecionáveis</a>
            <a href="locais.php">Locais</a>
            <a href="logout.php">Sair</a>
        </nav>

        <p>Acompanhe o mural de progresso dos jogadores.</p>
    </header>

    <main>
        <section>
            <h2>Progresso atual do jogo:</h2>
            <?php if ($progressoAtual): ?>
                <p>Capítulo: <?php echo htmlspecialchars($progressoAtual["capNome"]); ?></p>
                <p>Item: <?php echo htmlspecialchars($progressoAtual["colNome"]); ?></p>
                <p>Status: Em andamento</p>
            <?php else: ?>
                <p>Não há progresso em andamento no momento.</p>
            <?php endif; ?>
        </section>

        <section>
            <h2>Progresso concluído dos jogadores:</h2>
            <?php if (count($progressoAntigos) > 0): ?>
                <ul>
                    <?php foreach ($progressoAntigos as $prog): ?>
                        <li>
                            Jogador:
                            <?php
                                echo $prog["jogApel"]
                                    ? htmlspecialchars($prog["jogApel"])
                                    : "Sem jogador vinculado";
                            ?>
                            —
                            Capítulo: <?php echo htmlspecialchars($prog["capNome"]); ?>
                            —
                            Item: <?php echo htmlspecialchars($prog["colNome"]); ?>
                            —
                            Concluído em: <?php echo htmlspecialchars($prog["progDataConclusao"]); ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Nenhum jogador concluiu progresso ainda.</p>
            <?php endif; ?>
        </section>

        <section>
            <h2>Começar um novo progresso:</h2>
            <p>Inicie um novo registro de gameplay que será exibido para todos os jogadores.</p>
            <form action="novo_progresso.php" method="get">
                <button type="submit">Começar novo progresso</button>
            </form>
        </section>
    </main>
</div>
</body>
</html>
