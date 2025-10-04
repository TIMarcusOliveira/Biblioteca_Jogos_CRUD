<!-- delete nesse tbm -->
<?php
    include_once('../../includes/conn.php');
    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: ../login/login.php");
        exit;
    }

    $user_id = $_SESSION["user"]["id"];
    $sql = "SELECT * FROM jogos where usuario_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $games = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
    
    $cover_image = $game['imagem_capa'];
    $title = htmlspecialchars($game['nome']);
    $genre = htmlspecialchars($game['genero']);
    $platform = htmlspecialchars($game['plataformas']);
    $release_year = htmlspecialchars($game['ano_lancamento']);
    $edit_link = "updategame.php?id=" . $game['id'];
    $delete_link = "deletegame.php?id=" . $game['id'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Biblioteca de Jogos </title>
    <link rel="stylesheet" href="../../public/css/read.css">
</head>
<body>
    <main>
        <div class="scard">
            <?php if (!empty($cover_image)): ?>
                <img src="<?= $cover_image ?>" alt="Capa do jogo" style="max-width:150px;max-height:150px;"> <br>
            <?php else: ?>
                <img src="" alt="Sem Capa do jogo" style="max-width:150px;max-height:150px;"> <br>
            <?php endif; ?>
        </div>





        <div class="game-control">
            <?php foreach ($games as $game): ?>
                <div class="game-item">
                <?php if (!empty($cover_image)): ?>
                    <img src="<?= $cover_image ?>" alt="Capa do jogo" style="max-width:150px;max-height:150px;"> <br>
                <?php endif; ?>
                    <strong>Título:</strong> <?= $title . $cover_image ?><br>
                    <strong>Gênero:</strong> <?= $genre ?><br>
                    <strong>Plataforma:</strong> <?= $platform ?><br>
                    <strong>Ano de Lançamento:</strong> <?= $release_year ?><br>
                    <a href="<?= $edit_link ?>">Editar</a> | 
                    <a href="<?= $delete_link ?>" onclick="return confirm('Tem certeza que deseja deletar este jogo?');">Deletar</a>
                </div>
            <?php endforeach; ?>
        </div>
        <nav>
            <a href="../index.php"> Voltar para Home </a>
            <a href="creategame.php"> Adicionar novo jogo </a> 
        </nav>
    </main>
</body>
</html>