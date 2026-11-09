<?php 

include "conexao.php";

$msgErro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST["jogNome"]);
    $email = trim($_POST["jogEmail"]);
    $apelido = trim($_POST["jogApel"]);

    if (empty($nome) || empty($email) || empty($apelido)) {
        $msgErro = "Todos os campos são obrigatórios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msgErro = "E-mail inválido.";
    } else {
        $stmtCheck = $sql->prepare("SELECT idJog FROM jogador WHERE jogEmail = ? OR jogApel = ?");
        $stmtCheck->bind_param("ss", $email, $apelido);
        $stmtCheck->execute();
        $stmtCheck->store_result();

        if ($stmtCheck->num_rows > 0) {
            $msgErro = "E-mail ou apelido já cadastrados.";
        } else {
            
            $stmt = $sql->prepare("INSERT INTO jogador (jogNome, jogEmail, jogApel, idProg) VALUES (?, ?, ?, NULL)");
            $stmt->bind_param("sss", $nome, $email, $apelido);

            if ($stmt->execute()) {
                header("Location: loginusuario.php");
                exit();
            } else {
                $msgErro = "Erro ao cadastrar: " . $stmt->error;
            }
            $stmt->close();
        }
        $stmtCheck->close();
    }
}

$sql->close();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrando novo usuário</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/cadastroUsuario.css">
</head>
<body>
    <div class="cont">
        <div id="barrasuperior">
            <img id="fotobarra" src="../images/logoalternativa.png">
            
            <h1 id="textobarra"> Comece sua própria aventura!</h1>
        </div>

        <div id="form">

            <?php if (!empty($msgErro)): ?>
                <div style="color: red; margin-bottom: 10px;">
                    <?php echo $msgErro; ?>
                </div>
            <?php endif; ?>

                <form method="POST" action="">
                    <div class="formItem">
                        <label for="jogNome"> Informe seu nome: </label>
                            <input type="text" id="jogNome" name="jogNome" required> 
                    </div>  

                    <div class="formItem"> 
                        <label for="jogEmail"> Informe seu e-mail: </label>
                            <input type="email" id="jogEmail" name="jogEmail" required> 
                    </div> 

                    <div class="formItem"> 
                        <label for="jogApel"> Crie seu apelido: </label>
                        <input type="text" id="jogApel" name="jogApel" required> 
                    </div> 

                    <button type="submit"> Cadastrar </button>
            </form>
        </div>
    </div>
</body>
</html>