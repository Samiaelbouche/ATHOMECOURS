<?php require_once __DIR__ . '/../php/config.php'; ?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>AT HOME COURS</title>
        <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
    </head>
        <body>

            <header>

                <nav>
                     <div class="logo">
                        <a href="../views/home.php"><img src="../images/logo.png" alt="Logo"></a>
                    </div>
                    <ul>


                        <li><a href=""> Nos Cours</a></li>
                        <li><a href="">Nos  Professeur(e)s</a></li>
                        <li><a href="">Nos  Taris</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                    <div class="boutonconnexion">
                        <?php if (isset($_SESSION['user'])): ?>
                            <span>Bonjour, <?= htmlspecialchars($_SESSION['user']['prenom']) . ' ' . htmlspecialchars($_SESSION['user']['nom']); ?></span>
                            <a href="../php/deconnexion.php" class="btn">Déconnexion</a>
                        <?php else: ?>
                            <a href="../template/inscription.html" class="btn">Inscription</a>
                            <a href="../php/connexion.php" class="btn">Connexion</a>
                        <?php endif; ?>
                    </div>
                </nav>
                </nav>
            </header>

            <main>