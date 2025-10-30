<?php
include_once('../../includes/conn.php');
include_once('../../includes/session.php');

$sql = "SELECT * FROM jogos WHERE usuario_id = :user_id ORDER BY nome ASC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$games = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$games) {
    $msg = "Nenhum jogo encontrado.";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biblioteca de Jogos</title>
    <link rel="stylesheet" href="../../public/css/global.css">
    <link rel="stylesheet" href="../../public/css/read.css">
</head>
<body>
    <header>
        <nav>
            <a href="../index.php">Voltar para Home</a>
            <a href="creategame.php">Adicionar novo jogo</a>
        </nav>

        <h1>GameLib</h1>
        
        <button id="toggleBtn">Mudar cor</button>

    </header>

    <main>
        <h1> <?= $msg ?? ''?> </h1>
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

                <div class="game-item" id="caixa">
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
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script>
        const btn = document.getElementById('toggleBtn');
        const cards = document.querySelectorAll('.game-item');

        btn.addEventListener('click', () => {
            cards.forEach(card => {
                card.classList.toggle('ativo'); // alterna a cor de todos os cards
            });
        });
    </script>
</body>
</html>
