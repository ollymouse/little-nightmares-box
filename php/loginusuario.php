<?php 

session_start();
include "conexao.php";

$msgErro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["jogEmail"]);
    if (empty($email)) {
        $msgErro = "Por favor, preencha o campo de e-mail.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msgErro = "E-mail inválido.";
    } else {
        $stmt = $sql->prepare("SELECT idJog, jogApel FROM jogador WHERE jogEmail = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($idJog, $jogApel);
            $stmt->fetch();

            $_SESSION["idJog"] = $idJog;
            $_SESSION["apelido"] = $jogApel;

            header("Location: main.php");
            exit();
        } else {
            $msgErro = "Usuário não encontrado.";
        }
        $stmt->close();
    }
}
$sql->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/loginUsuario.css">
</head>
<body>
<div id="cont">
    <div id="form">
        <?php if (!empty($msgErro)): ?>
            <div style="color: red; margin-bottom: 10px;">
                <?php echo $msgErro; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="formItem">
                <label for="jogEmail"> Insira o e-mail cadastrado: </label>
                <input type="email" id="jogEmail" name="jogEmail" required> 
            </div>

            <button type="submit"> Entrar </button>
        </form>
    </div>
</div>
</body>
</html>
