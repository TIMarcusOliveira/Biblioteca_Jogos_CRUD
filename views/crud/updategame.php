<?php
include_once('../../includes/conn.php');
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../login/login.php");
    exit;
}

if (isset($_GET['id'])) {
    $game_id = $_GET['id'];
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

if (isset($_POST['update'])) {
    $nome = $_POST['nome'];
    $genero = $_POST['genero'];
    $ano_lancamento = $_POST['ano_lancamento'];
    $plataformas = isset($_POST["plataformas"]) ? implode(", ", $_POST["plataformas"]) : "";

    $upload_dir = '../../public/upload/';
    include_once('../../includes/upload.php');
    if (empty($imagem_capa)) {
        $imagem_capa = $game['imagem_capa'];
    }

    $sql = "UPDATE jogos 
            SET nome = :nome, imagem_capa = :imagem_capa, genero = :genero, plataformas = :plataformas, ano_lancamento = :ano_lancamento 
            WHERE id = :id AND usuario_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':imagem_capa', $imagem_capa);
    $stmt->bindParam(':genero', $genero);
    $stmt->bindParam(':plataformas', $plataformas);
    $stmt->bindParam(':ano_lancamento', $ano_lancamento);
    $stmt->bindParam(':id', $game_id);
    $stmt->bindParam(':user_id', $_SESSION["user"]["id"]);

    if ($stmt->execute()) {
        header("Location: readgame.php");
        exit;
    } else {
        $msg = "Erro ao atualizar o jogo.";
    }
}

$plataformasSelecionadas = array_map('trim', explode(',', $game['plataformas'] ?? ''));
$todasPlataformas = [
    "PC", "PlayStation 5", "PlayStation 4",
    "Xbox Series X/S", "Xbox One", "Nintendo Switch",
    "Mobile", "Outro"
];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Jogo</title>
    <link rel="stylesheet" href="../../public/css/global.css">
    <link rel="stylesheet" href="../../public/css/create.css">
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
        <form action="" method="post" enctype="multipart/form-data">
            <div class="rows">
                <div class="form-control">
                    <label for="nome">Título do Jogo:</label>
                    <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($game['nome']) ?>" required>
                </div>
            </div>

            <div class="rows" id="double">
                <div class="form-control">
                    <label for="genero">Gênero:</label>
                    <input type="text" id="genero" name="genero" value="<?= htmlspecialchars($game['genero']) ?>" required>
                </div>

                <div class="form-control">
                    <label for="ano_lancamento">Ano de Lançamento:</label>
                    <input type="number" id="ano_lancamento" name="ano_lancamento" min="1970" max="2030" value="<?= htmlspecialchars($game['ano_lancamento']) ?>" required>
                </div>
            </div>

            <div class="rows">
                <div class="form-control">
                    <label>Plataformas:</label>
                    <div class="checkbox-group">
                        <?php foreach ($todasPlataformas as $plataforma): 
                            $checked = in_array($plataforma, $plataformasSelecionadas) ? 'checked' : ''; ?>
                            <label><input type="checkbox" name="plataformas[]" value="<?= $plataforma ?>" <?= $checked ?>> <?= $plataforma ?></label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="form-control" id="file">
                <label for="imagem_capa">Imagem da Capa:</label>
                <input type="file" id="imagem_capa" name="imagem_capa">
                <?php if (!empty($game['imagem_capa'])): ?>
                    <img src="<?= htmlspecialchars($game['imagem_capa']) ?>" alt="Capa atual" style="max-width:100px; margin-top:10px;">
                <?php endif; ?>
            </div>

            <input type="submit" value="Atualizar Jogo" name="update">

            <div class="actions">
                <a href="searchgame.php">Voltar</a>
                <a href="../index.php">Página inicial</a>
            </div>
        </form>
    </main>
</body>
</html>
