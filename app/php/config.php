<?php

$dsn = 'mysql:host=mysql;dbname=athomecours;charset=utf8';
$user = 'root';
$password = 'root_password';

    try{
        $pdo = new PDO($dsn , $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }
