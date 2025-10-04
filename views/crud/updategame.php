<?php
    include_once('../../includes/conn.php');
    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: ../login/login.php");
        exit;
    }

    if(isset($_GET['id'])) {
        $game_id = $_GET['id'];
        // Fetch game details from the database
        $sql = "SELECT * FROM jogos WHERE id = :id AND usuario_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $game_id);
        $stmt->bindParam(':user_id', $_SESSION["user"]["id"]);
        $stmt->execute();
        $game = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$game) {
            echo "Jogo não encontrado ou você não tem permissão para editá-lo.";
            exit;
        }
    } else {
        echo "ID do jogo não fornecido.";
        exit;
    }

    if(isset($_POST['nome'], $_POST['genero'], $_POST['ano_lancamento'])) {
        $nome = $_POST['nome'];
        $genero = $_POST['genero'];
        $ano_lancamento = $_POST['ano_lancamento'];
        
        // Update game details in the database
        $upload_dir = '../../public/upload/';
        include_once('../../includes/upload.php');
        
        if (empty($imagem_capa)) {
                $imagem_capa = $game['imagem_capa'];
        }
        
        $sql = "UPDATE jogos SET nome = :nome, imagem_capa = :imagem_capa, genero = :genero, ano_lancamento = :ano_lancamento WHERE id = :id AND usuario_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':imagem_capa', $imagem_capa);
        $stmt->bindParam(':genero', $genero);
        $stmt->bindParam(':ano_lancamento', $ano_lancamento);
        $stmt->bindParam(':id', $game_id);
        $stmt->bindParam(':user_id', $_SESSION["user"]["id"]);

        if($stmt->execute()) {
            echo "Jogo atualizado com sucesso.";
            header("Location: readgame.php");
            exit;
        } else {
            echo "Erro ao atualizar o jogo.";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Atualizar registros </title>
</head>
<body>
    <div class="form-control">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" name="nome" value="<?php echo htmlspecialchars($game['nome']); ?>" placeholder="Nome do jogo" required>
            <input type="file" name="imagem_capa"> <img src="<?php if(isset($game['imagem_capa'])) echo htmlspecialchars($game['imagem_capa']); ?>" alt="Capa atual" style="max-width:100px;max-height:100px;">
            <input type="text" name="genero" value="<?php echo htmlspecialchars($game['genero']); ?>" placeholder="Gênero do jogo" required>
            <input type="number" name="ano_lancamento" value="<?php echo htmlspecialchars($game['ano_lancamento']); ?>" placeholder="Ano de lançamento" required>
            <button type="submit">Atualizar</button>
        </form>
    </div>
</body>
</html>