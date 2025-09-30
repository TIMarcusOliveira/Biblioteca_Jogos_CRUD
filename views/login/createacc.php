<?php
require_once('../../includes/conn.php');
session_start();

if(isset($_POST['user']) && isset($_POST['password'])) {
  $user = $_POST['user'];
  $password = $_POST['password'];
  $confirm = $_POST['confirm']; 
  
  if($password !== $confirm) {
    $msg = "As senhas não coincidem.";
  } else {
    $check = $pdo->prepare("SELECT * FROM usuarios WHERE username = :username");
    $check->bindParam(':username', $user);
    $check->execute();

    if($check->rowCount() > 0) {
      $msg = "Nome de usuário já existe.";
    } else {
      $hash = hash('sha256', $password);

      $sql = "INSERT INTO usuarios (username, senha) VALUES (:username, :password)";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':username', $user);
      $stmt->bindParam(':password', $hash);
      
      if($stmt->execute()) {
        echo "<script>alert('Conta criada com sucesso!');</script>";
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
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cadastro</title>
  </head>
  <body>
    <form action="#" method="post">
      <p class="errormsg">
        <?php if(isset($msg)) { echo $msg; } ?>
      </p>
      <label for="user"> Nome de usuário </label>
      <input type="text" name="user" />

      <label for="password"> Senha </label>
      <input type="password" name="password" />

      <label for="confirm"> Confirme a senha </label>
      <input type="password" name="confirm" />

      <input type="submit" value="Cadastrar" />
      <a href="login.php">Já tem uma conta? Faça login</a>
    </form>
  </body>
</html>
