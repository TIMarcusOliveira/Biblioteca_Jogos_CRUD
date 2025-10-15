<?php
    include_once('../../includes/conn.php');
    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: ../login/login.php");
        exit;
    }

    if (!isset($_GET['id'])) {
        header("Location: readgame.php");
        exit;
    }

    $user_id = $_SESSION["user"]["id"];
    $sql = "SELECT * FROM jogos WHERE usuario_id = :user_id and id = :id ORDER BY nome ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $games = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$games) {
        echo "Nenhum jogo encontrado.";
        exit;
    }

    if (isset($_POST['id'])) {
        $sql = "DELETE FROM jogos WHERE id = :id AND usuario_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $_POST['id']);
        $stmt->bindParam(':user_id', $_SESSION["user"]["id"]);
        if ($stmt->execute()) {
            header("Location: readgame.php");
            exit;
        } else {
            echo "Erro ao apagar o jogo.";
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/global.css">
    <link rel="stylesheet" href="../../public/css/read.css">
    <link rel="stylesheet" href="../../public/css/delete.css">
    <title> Apagar Registros </title>
</head>
<body>
    <header>
        <nav>
            <a href="../index.php">Voltar para Home</a>
            <a href="readgame.php">Meus jogos</a>
        </nav>

        <h1>GameLib</h1>
    </header>
    <main>
        <div class="u-sure">
            <h1> Apagar Jogo </h1>
            <p> Você tem certeza que deseja apagar este jogo? </p>
        </div>
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
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id']) ?>">
            <input type="submit" value="Sim, apagar">
            <a href="searchgame.php"> Não, voltar </a>
        </form>
    </main>
</body>
</html>