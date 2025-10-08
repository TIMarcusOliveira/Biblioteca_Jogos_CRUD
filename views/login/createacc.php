<?php
require_once('../../includes/conn.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user = trim($_POST['user'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm = trim($_POST['confirm'] ?? '');

    if (empty($user) || empty($password) || empty($confirm)) {
        $msg = "Preencha todos os campos.";
    }
    elseif ($password !== $confirm) {
        $msg = "As senhas não coincidem.";
    }
    else {
        $check = $pdo->prepare("SELECT * FROM usuarios WHERE username = :username");
        $check->bindParam(':username', $user);
        $check->execute();

        if ($check->rowCount() > 0) {
            $msg = "Nome de usuário já existe.";
        } else {
            $hash = hash('sha256', $password);

            $sql = "INSERT INTO usuarios (username, senha) VALUES (:username, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':username', $user);
            $stmt->bindParam(':password', $hash);

            if ($stmt->execute()) {
                header('Location: login.php');
                exit;
            } else {
                $msg = "Erro ao criar conta. Tente novamente.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../public/css/global.css" />
    <link rel="stylesheet" href="../../public/css/login.css" />
    <title>Cadastro</title>
  </head>
  <body>
    <form action="#" method="post">
      <h1> Crie sua conta </h1>
      <p class="errormsg">
        <?php if(isset($msg)) { echo $msg; } ?>
      </p>
      <div class="form-control">
        <label for="user"> Nome de usuário </label>
        <input type="text" name="user" required/>
  
        <label for="password"> Senha </label>
        <input type="password" name="password" required/>
  
        <label for="confirm"> Confirme a senha </label>
        <input type="password" name="confirm" required/>
      </div>

      <input type="submit" value="Cadastrar" />
      <div class="actions">
        <a href="../../index.html" id="back"> Home </a>
        <a href="login.php">Já tem uma conta? Faça login</a>
      </div>
    </form>
  </body>
</html>
