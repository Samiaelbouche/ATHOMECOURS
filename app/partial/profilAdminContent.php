<?php

$stats = $stats ?? [
    'totalEleves' => 0,
    'totalProfs'  => 0,
    'totalCours'  => 0,
    'coursConf'   => 0,
    'coursAnn'    => 0,
];

$attentesProfs  = $attentesProfs  ?? [];
$attentesEleves = $attentesEleves ?? [];
?>


    <h1 class="admin-title">
        Bienvenue <?= htmlspecialchars($_SESSION['user_prenom'] ?? 'Admin') ?>
    </h1>

    <div class="admin-dashboard">
        <div class="admin-card"><h3>Total élèves</h3><p><?= $stats['totalEleves'] ?></p></div>
        <div class="admin-card"><h3>Total professeurs</h3><p><?= $stats['totalProfs'] ?></p></div>
        <div class="admin-card"><h3>Total cours</h3><p><?= $stats['totalCours'] ?></p></div>
        <div class="admin-card"><h3>Cours confirmés</h3><p><?= $stats['coursConf'] ?></p></div>
        <div class="admin-card"><h3>Cours annulés</h3><p><?= $stats['coursAnn'] ?></p></div>
    </div>

    <h2 class="admin-subtitle">Professeurs en attente</h2>
<?php if (empty($attentesProfs)): ?>
    <p class="admin-empty">Aucun professeur en attente.</p>
<?php else: ?>
    <table class="admin-table">
        <tr><th>Nom</th><th>Email</th><th>Action</th></tr>
        <?php foreach ($attentesProfs as $prof): ?>
            <tr>
                <td data-label="Nom"><?= htmlspecialchars($prof['prenom'].' '.$prof['nom']) ?></td>
                <td data-label="Email"><?= htmlspecialchars($prof['email']) ?></td>
                <td data-label="Action">
                    <form method="post" action="../admin/adminController.php" class="admin-actions">
                        <input type="hidden" name="id" value="<?= (int)$prof['id'] ?>">
                        <input type="hidden" name="type" value="professeur">
                        <button type="submit" name="action" value="valide">Valider</button>
                        <button type="submit" name="action" value="refuse">Refuser</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

    <h2 class="admin-subtitle">Élèves en attente</h2>
<?php if (empty($attentesEleves)): ?>
    <p class="admin-empty">Aucun élève en attente.</p>
<?php else: ?>
    <table class="admin-table">
        <tr><th>Nom</th><th>Email</th><th>Action</th></tr>
        <?php foreach ($attentesEleves as $eleve): ?>
            <tr>
                <td data-label="Nom"><?= htmlspecialchars($eleve['prenom'].' '.$eleve['nom']) ?></td>
                <td data-label="Email"><?= htmlspecialchars($eleve['email']) ?></td>
                <td data-label="Action">
                    <form method="post" action="../admin/adminController.php" class="admin-actions">
                        <input type="hidden" name="id" value="<?= (int)$eleve['id'] ?>">
                        <input type="hidden" name="type" value="eleve">
                        <button type="submit" name="action" value="valide">Valider</button>
                        <button type="submit" name="action" value="refuse">Refuser</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>