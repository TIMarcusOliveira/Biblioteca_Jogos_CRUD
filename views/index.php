<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login/login.php");
    exit;
}

$user = $_SESSION["user"]["username"] ?? "Usuário";
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>GameLib</title>
    <link rel="stylesheet" href="../public/css/global.css" />
    <link rel="stylesheet" href="../public/css/home.css" />
  </head>
  <body>
    <header>
      <nav>
        <a href="./crud/readgame.php">Biblioteca</a>
        <a href="./crud/creategame.php">Registrar Jogo</a>
        <a href="./crud/searchgame.php">Atualizar Registros</a>
      </nav>
      <h1>GameLib</h1>
      <a href="./login/logout.php">
        <img src="../public/img/logout.png" alt="Sair" style="height:50px; width:auto;">
      </a>
    </header>

    <main class="dashboard">
      <h2>Bem-vindo(a), <?php echo htmlspecialchars($user); ?>!</h2>
      <p class="subtitle">Gerencie seus jogos facilmente.</p>

      <section class="cards">
        <a href="./crud/readgame.php" class="card">
          <img src="../public/img/library.png" alt="Biblioteca" />
          <h3>Biblioteca</h3>
          <p>Veja todos os seus jogos cadastrados.</p>
        </a>

        <a href="./crud/creategame.php" class="card">
          <img src="../public/img/add.png" alt="Adicionar Jogo" />
          <h3>Registrar Jogo</h3>
          <p>Adicione novos títulos à sua coleção.</p>
        </a>

        <a href="./crud/searchgame.php" class="card">
          <img src="../public/img/edit.png" alt="Editar Jogo" />
          <h3>Atualizar Registros</h3>
          <p>Edite ou remova jogos existentes.</p>
        </a>
      </section>
    </main>

    <footer>
      <p>© 2025 GameLib — Desenvolvido por Marcus Vinicius de Paula Oliveira</p>
    </footer>
  </body>
</html>
