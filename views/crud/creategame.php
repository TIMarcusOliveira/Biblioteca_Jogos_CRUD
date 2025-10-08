<?php
    include_once('../../includes/conn.php');
    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: ../login/login.php");
        exit;
    }


    $user_id = $_SESSION["user"]["id"];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = $_POST['nome'];
        $genero = $_POST['genero'];
        $ano_lancamento = $_POST['ano_lancamento'];
        
        $imagem_capa = null;
        $upload_dir = '../../public/upload/';
        include_once('../../includes/upload.php');

        // Combina as plataformas marcadas em uma string separada por vírgulas
        $plataformas = isset($_POST["plataformas"]) ? implode(", ", $_POST["plataformas"]) : ""; 

        $sql = "INSERT INTO jogos (nome, genero, plataformas, ano_lancamento, imagem_capa, usuario_id) 
                VALUES (:nome, :genero, :plataformas, :ano_lancamento, :imagem_capa, :usuario_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':genero', $genero);
        $stmt->bindParam(':plataformas', $plataformas);
        $stmt->bindParam(':ano_lancamento', $ano_lancamento);
        $stmt->bindParam(':imagem_capa', $imagem_capa);
        $stmt->bindParam(':usuario_id', $user_id);
        
        if ($stmt->execute()) {
            header("Location: readgame.php");
            exit;
        } else {
            echo "Erro ao registrar o jogo.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Registrar jogos </title>
    <link rel="stylesheet" href="../../public/css/global.css">
    <link rel="stylesheet" href="../../public/css/create.css">
</head>
<body>
    <header>
        <nav>
            <a href="../index.php">Voltar para Home</a>
            <a href="readgame.php">Meus jogos</a>
        </nav>

        <h1>Biblioteca de Jogos</h1>
    </header>
    <main>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="rows"> 
                <div class="form-control">
                    <label for="nome">Título do Jogo:</label>
                    <input type="text" id="nome" name="nome" required>
                </div>
            </div>
        
            <div class="rows" id="double">
                <div class="form-control">
                    <label for="genero">Gênero:</label>
                    <input type="text" id="genero" name="genero" required>
                </div>
    
                <div class="form-control">
                    <label for="ano_lancamento">Ano de Lançamento:</label>
                    <input type="number" id="ano_lancamento" name="ano_lancamento" min="1970" max="2030" required>
                </div>
            </div>
            <div class="rows">
                <div class="form-control">
                    <label>Plataformas:</label>
                    <div class="checkbox-group">
                    <label><input type="checkbox" name="plataformas[]" value="PC" /> PC</label>
                    <label><input type="checkbox" name="plataformas[]" value="PlayStation 5" /> PlayStation 5</label>
                    <label><input type="checkbox" name="plataformas[]" value="PlayStation 4" /> PlayStation 4</label>
                    <label><input type="checkbox" name="plataformas[]" value="Xbox Series X/S" /> Xbox Series X/S</label>
                    <label><input type="checkbox" name="plataformas[]" value="Xbox One" /> Xbox One</label>
                    <label><input type="checkbox" name="plataformas[]" value="Nintendo Switch" /> Nintendo Switch</label>
                    <label><input type="checkbox" name="plataformas[]" value="Mobile" /> Mobile</label>
                    <label><input type="checkbox" name="plataformas[]" value="Outro" /> Outro</label>
                    </div>
        
                </div>
            </div>
                
    
            <div class="form-control" id="file">
                <label for="imagem_capa">Imagem da Capa:</label>
                <input type="file" id="imagem_capa" name="imagem_capa">
            </div>
    
            <input type="submit" value="Registrar Jogo">
        </form>
    </main>
</body>
</html>