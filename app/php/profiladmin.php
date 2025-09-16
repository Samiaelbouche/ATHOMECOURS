<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once __DIR__ . '/config.php';

    if (empty($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
        header("Location: /php/connexion.php");
        exit;
    }

    $totalEleves = $pdo->query("SELECT COUNT(*) FROM eleves")->fetchColumn();
    $totalProfs = $pdo->query("SELECT COUNT(*) FROM professeurs")->fetchColumn();
    $totalCours = $pdo->query("SELECT COUNT(*) FROM cours")->fetchColumn();
    $coursConf = $pdo->query("SELECT COUNT(*) FROM cours WHERE statut='confirme'")->fetchColumn();
    $coursAnn  = $pdo->query("SELECT COUNT(*) FROM cours WHERE statut='annule'")->fetchColumn();

    $profs = $pdo->query("SELECT * FROM professeurs WHERE statut='en_attente'")->fetchAll();
    $eleves = $pdo->query("SELECT * FROM eleves WHERE statut='en_attente'")->fetchAll();

    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Tableau de bord</title>

</head>
    <body>

        <h1>Tableau de bord Administrateur</h1>


        <div class="dashboard">
            <div class="card"><h3>Total élèves</h3><p><?= $totalEleves ?></p></div>
            <div class="card"><h3>Total professeurs</h3><p><?= $totalProfs ?></p></div>
            <div class="card"><h3>Total cours</h3><p><?= $totalCours ?></p></div>
            <div class="card"><h3>Cours confirmés</h3><p><?= $coursConf ?></p></div>
            <div class="card"><h3>Cours annulés</h3><p><?= $coursAnn ?></p></div>
        </div>


        <h2>Professeurs en attente</h2>
        <table>
            <tr><th>Nom</th><th>Email</th><th>Action</th></tr>
            <?php foreach ($profs as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p['prenom']." ".$p['nom']) ?></td>
                    <td><?= htmlspecialchars($p['email']) ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <input type="hidden" name="type" value="prof">
                            <button type="submit" name="action" value="valide">Valider</button>
                            <button type="submit" name="action" value="refuse">Refuser</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>


        <h2>Élèves en attente</h2>
        <table>
            <tr><th>Nom</th><th>Email</th><th>Action</th></tr>
            <?php foreach ($eleves as $e): ?>
                <tr>
                    <td><?= htmlspecialchars($e['prenom']." ".$e['nom']) ?></td>
                    <td><?= htmlspecialchars($e['email']) ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="id" value="<?= $e['id'] ?>">
                            <input type="hidden" name="type" value="eleve">
                            <button type="submit" name="action" value="valide">Valider</button>
                            <button type="submit" name="action" value="refuse">Refuser</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

    </body>
</html>