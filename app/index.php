<?php

require_once "php/config.php";

/** @var PDO $pdo */

$query = $pdo->prepare('SELECT * FROM eleves ');

$query->execute();

$posts = $query->fetchAll(PDO::FETCH_ASSOC);