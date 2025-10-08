<?php
require_once('../../includes/conn.php');
session_start();

if(isset($_POST['user']) && isset($_POST['password'])) {
  $user = $_POST['user'];
  $password = $_POST['password'];
  
  $sql = "SELECT * FROM usuarios WHERE username = :username AND senha = :password LIMIT 1";

  $hash = hash('sha256', $password);

  $stmt = $pdo->prepare($sql);
  $stmt->bindParam(':username', $user);
  $stmt->bindParam(':password', $hash);
  $stmt->execute();

  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if(!$user) {
    $msg = "Usuário ou senha inválidos.";
  } 
  if($user && hash('sha256', $password) === $user['senha']) {
    echo "<script>alert('Login bem-sucedido!');</script>";
    $_SESSION['user'] = $user;
    header('Location: ../index.php');
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../public/css/global.css" />
    <link rel="stylesheet" href="../../public/css/login.css" />
    <title>Login</title>
  </head>
  <body>
    <form action="" method="post">
      <h1> Acesse sua conta </h1>
      <p class="errormsg">
        <?php if(isset($msg)) { echo $msg; } ?>
      </p>
      <div class="form-control">

        <label for="user"> Nome de usuário </label>
        <input type="text" name="user" required/>
  
        <label for="password"> Senha </label>
        <input type="password" name="password" required/>
      </div>

      <input type="submit" value="Login" required/>
      <div class="actions">
        <a href="../../index.html" id="back"> Home </a>
        <a href="createacc.php">Não possui cadastro? Crie uma nova conta</a>
      </div>
    </form>
  </body>
</html>
