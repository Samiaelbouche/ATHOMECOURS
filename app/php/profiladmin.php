<?php
session_start();
require_once __DIR__ . '/config.php';

if (empty($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = (int)$_POST["id"];
    $type = $_POST["type"];
    $action = $_POST["action"];

    if ($type === "prof") {
        $stmt = $pdo->prepare("UPDATE professeurs SET statut=:s WHERE id=:id");
    } elseif ($type === "eleve") {
        $stmt = $pdo->prepare("UPDATE eleves SET statut=:s WHERE id=:id");
    }
    if (isset($stmt)) {
        $stmt->execute([":s" => $action, ":id" => $id]);
    }

    header("Location: profil_admin.php");
    exit;
}

$profs = $pdo->query("SELECT * FROM professeurs WHERE statut='en_attente'")->fetchAll();
$eleves = $pdo->query("SELECT * FROM eleves WHERE statut='en_attente'")->fetchAll();
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Admin</title></head>
<body>
<h2>Professeurs en attente</h2>
<table ">
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
<table >
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
