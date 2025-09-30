<!-- delete nesse tbm -->
<?php
    session_start();
    if (!isset($_SESSION["user"])) {
        header("Location: ../login/login.php");
        exit;
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Biblioteca de Jogos </title>
</head>
<body>
    
</body>
</html>