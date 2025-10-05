<?php
include_once('../../includes/conn.php');
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: ../login/login.php");
    exit;
}

$user_id = $_SESSION["user"]["id"];
$sql = "SELECT * FROM jogos WHERE usuario_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$games = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$games) {
    echo "Nenhum jogo encontrado.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca de Jogos</title>
    <link rel="stylesheet" href="../../public/css/read.css">
</head>
<body>
    <header>
        <nav>
            <a href="../index.php">Voltar para Home</a>
            <a href="creategame.php">Adicionar novo jogo</a>
        </nav>

        <h1>Biblioteca de Jogos</h1>
    </header>

    <main>
        <div class="game-control">
            <?php foreach ($games as $game): ?>
                <?php
                    $cover_image = htmlspecialchars($game['imagem_capa']);
                    $title = htmlspecialchars($game['nome']);
                    $genre = htmlspecialchars($game['genero']);
                    $platform = htmlspecialchars($game['plataformas']);
                    $release_year = htmlspecialchars($game['ano_lancamento']);
                    $edit_link = "updategame.php?id=" . $game['id'];
                    $delete_link = "deletegame.php?id=" . $game['id'];
                ?>
                <div class="game-item">
                    <?php if (!empty($cover_image)): ?>
                        <img src="<?= $cover_image ?>" alt="Capa do jogo"><br>
                    <?php else: ?>
                        <img src="../../public/img/default_game.png" alt="Sem capa"><br>
                    <?php endif; ?>

                    <div class="info">
                        <p id="title"><?= $title ?><br></p> 
                        <p id="gender">Gênero: <?= $genre ?><br></p>
                        <p id="platforms">Plataformas: <?= $platform ?><br></p>
                        <p id="rel_year">Ano de Lançamento: <?= $release_year ?><br></p>
                    </div>
                    <div class="actions">
                        <a href="<?= $edit_link ?>"><img src="../../public/img/edit-icon.png" alt="Editar"></a> 
                        <a href="<?= $delete_link ?>"><img src="../../public/img/thrash-icon.png" alt="Apagar"></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
