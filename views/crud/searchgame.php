fazer search q manda p o editar de vdd
terminar o updategame.php
<?php
    include_once('../../includes/conn.php');
    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: ../login/login.php");
        exit;
    }

    if(isset($_POST['search'])) {
        $searchTerm = $_POST['search'];
        // Fetch game details from the database
        $sql = "SELECT * FROM jogos WHERE nome LIKE :search AND usuario_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $likeSearchTerm = '%' . $searchTerm . '%';
        $stmt->bindParam(':search', $likeSearchTerm);
        $stmt->bindParam(':user_id', $_SESSION["user"]["id"]);
        $stmt->execute();
        $games = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$games) {
            echo "Nenhum jogo encontrado.";
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Pesquisa de registros </title>
</head>
<body>
    <main>
        <div class="form-control">
            <form action="" method="post">
                <input type="text" name="search" placeholder="Pesquisar jogos...">
                <button type="submit">Pesquisar</button>
            </form>
        </div>
        <div class="results">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Gênero</th>
                        <th>Ano de Lançamento</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($games)): ?>
                        <?php foreach ($games as $game): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($game['id']); ?></td>
                                <td><?php echo htmlspecialchars($game['nome']); ?></td>
                                <td><?php echo htmlspecialchars($game['genero']); ?></td>
                                <td><?php echo htmlspecialchars($game['ano_lancamento']); ?></td>
                                <td><a href="updategame.php?id=<?php echo $game['id']; ?>">Editar</a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">Nenhum jogo encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>