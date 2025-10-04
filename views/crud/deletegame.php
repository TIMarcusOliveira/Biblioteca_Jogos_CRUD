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

    // Optionally, you can verify if the game exists and belongs to the user
    $sql = "SELECT * FROM jogos WHERE id = :id AND usuario_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->bindParam(':user_id', $_SESSION["user"]["id"]);
    $stmt->execute();
    $game = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$game) {
        echo "Jogo não encontrado ou você não tem permissão para apagá-lo.";
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
    <title> Apagar Registros </title>
</head>
<body>
    <main>
        <h1> Apagar Registros </h1>
        <p> Você tem certeza que deseja apagar este jogo? </p>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id']) ?>">
            <button type="submit"> Sim, apagar </button>
            <a href="readgame.php"> Não, voltar </a>
        </form>
    </main>
</body>
</html>