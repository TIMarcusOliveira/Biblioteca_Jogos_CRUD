<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="../public/css/style.css" />
  </head>
  <body>
    <nav>
      <div class="vertical-nav">
        <a href="./crud/readgame.php"> Biblioteca </a>
        <a href="./crud/creategame.php"> Registrar Jogo </a>
        <a href="./crud/searchgame.php"> Atualizar Registros </a>
        <a href="./login/logout.php"> Encerrar sessão </a>
      </div>
    </nav>
  </body>
</html>
