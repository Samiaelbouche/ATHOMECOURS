<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../php/config.php';


if (!isset($template)) {
    die("Erreur : aucune page spécifiée.");
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AT HOME COURS</title>
        <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="../css/partial.css">
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/responsive.css">
        <link rel="stylesheet" href="../css/profil.css">
        <link rel="stylesheet" href="../css/mdp.css">
        <script src="https://kit.fontawesome.com/89acf86bb4.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <header>
            <nav>
                <div class="logo">
                    <a href="../views/home.php"><img src="../images/logo.png" alt="Logo"></a>
                </div>
                <ul id="premiernav">
                    <li><a href="../views/noscours.php">Nos Cours</a></li>
                    <li><a href="../views/nosprofesseurs.php">Nos Professeur(e)s</a></li>
                    <li><a href="../views/nostarifs.php">Nos Tarifs</a></li>
                    <li><a href="../views/contact.php">Contact</a></li>

                <li class="mobile-only">
                    <?php if (!empty($_SESSION['user_id'])): ?>
                        <span>
                            <a href="<?php
                            if (isset($_SESSION['role']) && $_SESSION['role'] === 'prof') {
                                echo '../php/profilprofphp';
                            } else {
                                echo '../php/profileleve.php';
                            }
                            ?>" class="btn">
                                <i class="fa-solid fa-user"></i>
                                <?= htmlspecialchars($_SESSION['user_prenom'] ?? '') . ' ' . htmlspecialchars($_SESSION['user_nom'] ?? '') ?>
                            </a>
                        </span>
                        <a href="../php/deconnexion.php" class="btn">Déconnexion</a>
                    <?php else: ?>
                        <a href="../views/inscription.php" class="btn">Inscription</a>
                        <a href="../views/connexionView.php" class="btn">Connexion</a>
                    <?php endif; ?>
                </li>
                </ul>

                 <div class="boutonconnexion desktop-only">
                    <?php if (!empty($_SESSION['user_id'])): ?>
                        <span>
                            <a href="<?php
                            if (isset($_SESSION['role']) && $_SESSION['role'] === 'prof') {
                                echo '../php/profilprofphp';
                            } else {
                                echo '../php/profileleve.php';
                            }
                            ?>" class="btn">
                                <i class="fa-solid fa-user"></i>
                                <?= htmlspecialchars($_SESSION['user_prenom'] ?? '') . ' ' . htmlspecialchars($_SESSION['user_nom'] ?? '') ?>
                            </a>
                        </span>
                        <a href="../php/deconnexion.php" class="btn">Déconnexion</a>
                    <?php else: ?>
                        <a href="../views/inscription.php" class="btn">Inscription</a>
                        <a href="../views/connexionView.php" class="btn">Connexion</a>
                    <?php endif; ?>
                </div>
                <div class="burger" id="burger" aria-label="Ouvrir le menu" aria-expanded="false" aria-controls="premiernav">
                    <span></span><span></span><span></span>
                </div>
            </nav>

        </header>

        <main>
            <?php include $template; ?>
        </main>

        <footer>
            <div class="footer">
                <div class="foot"> <h6> Nous rejoindre</h6>
                    <div class="ouverture">
                        <p> Du Lundi au vendredi de 18H00 à 21H00 </p>
                        <p> Le dimanche et samedi de 9h00 à 18h00 </p>
                        <p> Adresse : 212 Rue du Commerces, 92700 Colombes , France</p>
                    </div>
                </div>
                <div class="foot"> <h6> Nous contacter</h6>
                    <div class="lecontact">
                        <a href="athomecours@gmail.com" class="surligne"> <i class="fa-regular fa-envelope"></i> </a>
                        <a href="tel:+330626987145" class="surligne" ><i class="fa-solid fa-phone"></i></a>
                    </div>
                </div>
                <div > <h6>Nous suivre</h6>
                    <div class="reseau">
                        <a href="https://fr.linkedin.com/in/athomecours" target="_blank" class="surligne"><i class="fa-brands fa-linkedin" ></i></a>
                        <a href="https://www.instagram.com/athomecours/" target="_blank" class="surligne"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="footerbas"><p>&copy; 2025 AT HOME COURS Tous droits réservés.</p>
            </div>
        </footer>
    </body>

    <script src="../JS/partial.js"></script>

    <script src="../JS/home.js"></script>
</html>