<?php
    try{
        $pdo = new PDO("mysql:host=localhost;dbname=biblioteca_jogos", "root", "");
    } catch (PDOException $e){
        echo "Erro na conexão: " . $e->getMessage();
    } catch (Exception $e){
        echo "Erro genérico: " . $e->getMessage();
    }
?>