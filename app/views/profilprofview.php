<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>profilprof</title>
    </head>
    <body>

        <div class="profile">
                <h2>Profil Professeur</h2>
                <p>Bonjour <?= htmlspecialchars($_SESSION["user_prenom"] ?? '') . " " . htmlspecialchars($_SESSION["user_nom"] ?? '') ?></p>
        </div>

        <?php if (!empty($msg)): ?>
        <div class="msg"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>

        <h3>Ajouter une disponibilité</h3>
        <form method="post" action="">
            <input type="hidden" name="action" value="add_dispo">
            Jour :
            <select name="jour_semaine" required>
                <?php foreach (['lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche'] as $j): ?>
                <option value="<?= $j ?>"><?= ucfirst($j) ?></option>
                <?php endforeach; ?>
            </select>
            Début : <input type="time" name="heure_debut" required>
            Fin : <input type="time" name="heure_fin" required>
            <button type="submit">Ajouter</button>
        </form>

            <div class="card">
                <h3>Mes disponibilités</h3>
                <table>
                    <tr><th>Jour</th><th>Début</th><th>Fin</th><th>Statut</th><th>Actions</th></tr>
                    <?php foreach($dispos as $dispo): ?>
                    <tr>
                        <td><?= ucfirst($dispo['jour_semaine']) ?></td>
                        <td><?= substr($dispo['heure_debut'],0,5) ?></td>
                        <td><?= substr($dispo['heure_fin'],0,5) ?></td>
                        <td><?= $dispo['actif'] ? 'Actif' : 'Inactif' ?></td>
                        <td>
                            <form method="post" action="" class="inline">
                                <input type="hidden" name="action" value="toggle">
                                <input type="hidden" name="id" value="<?= (int)$dispo['id'] ?>">
                                <button type="submit"><?= $dispo['actif'] ? 'Désactiver' : 'Activer' ?></button>
                            </form>
                            <form method="post" action="" class="inline" onsubmit="return confirm('Supprimer cette disponibilité ?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= (int)$dispo['id'] ?>">
                                <button type="submit">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>

        <h3>Mes cours</h3>
        <table>
            <tr>
                <th>Élève</th>
                <th>Email</th>
                <th>Tél. Élève</th>
                <th>Tél. Parent</th>
                <th>Date</th>
                <th>Durée</th>
                <th>Lieu</th>
                <th>Adresse</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
            <?php if (!$cours): ?>
                <tr><td colspan="10">Aucun cours planifié.</td></tr>
            <?php else: ?>
                <?php foreach ($cours as $c): ?>
                    <tr>
                        <td><?= htmlspecialchars($c['prenom_eleve']." ".$c['nom_eleve']) ?></td>
                        <td><?= htmlspecialchars($c['email_eleve']) ?></td>
                        <td><?= htmlspecialchars($c['tel_eleve'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($c['tel_parent'] ?? '-') ?></td>
                        <td><?= date("d/m/Y H:i", strtotime($c['date_cours'])) ?></td>
                        <td><?= (int)$c['duree_minutes'] ?> min</td>
                        <td><?= htmlspecialchars($c['lieu']) ?></td>
                        <td><?= htmlspecialchars($c['adresse_cours'] ?? '-') ?></td>
                        <td><?= ucfirst($c['statut']) ?></td>
                        <td>
                            <?php if ($c['statut'] === 'planifie'): ?>
                                <form method="post" class="inline">
                                    <input type="hidden" name="action" value="confirme">
                                    <input type="hidden" name="cours_id" value="<?= $c['id'] ?>">
                                    <button type="submit">Confirmer</button>
                                </form>
                                <form method="post" class="inline" onsubmit="return confirm('Annuler ce cours ?')">
                                    <input type="hidden" name="action" value="annule">
                                    <input type="hidden" name="cours_id" value="<?= $c['id'] ?>">
                                    <button type="submit">Annuler</button>
                                </form>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>

    </body>

    </body>
</html>