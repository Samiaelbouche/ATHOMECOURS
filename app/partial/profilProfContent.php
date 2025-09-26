
<div class="prof-profile">
    <h2 class="prof-title">Profil Professeur(e)</h2>
    <p class="prof-welcome">
        Bonjour <?= htmlspecialchars($_SESSION["user_prenom"] ?? '') . " " . htmlspecialchars($_SESSION["user_nom"] ?? '') ?>
    </p>
</div>

    <?php if (!empty($msg)): ?>
    <div class="prof-msg"><?= htmlspecialchars($msg) ?></div>
    <?php endif; ?>
        <div class="proffond">
            <h2 class="prof-subtitle">Ajouter une disponibilité</h2>
            <form method="post" action="" class="prof-form">
                <input type="hidden" name="action" value="add_dispo">
                <label>Jour :</label>
                <select name="jour_semaine" required>
                    <?php foreach (['lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche'] as $j): ?>
                        <option value="<?= $j ?>"><?= ucfirst($j) ?></option>
                    <?php endforeach; ?>
                </select>
                <label>Début :</label>
                <input type="time" name="heure_debut" required>
                <label>Fin :</label>
                <input type="time" name="heure_fin" required>
                <button type="submit" class="prof-btn">Ajouter</button>
            </form>


            <h2 class="prof-subtitle">Mes disponibilités</h2>
            <table class="prof-table">
                <tr>
                    <th>Jour</th><th>Début</th><th>Fin</th><th>Statut</th><th>Actions</th>
                </tr>
                <?php foreach($dispos as $dispo): ?>
                    <tr>
                        <td data-label="Jour"><?= ucfirst($dispo['jour_semaine']) ?></td>
                        <td data-label="Début"><?= substr($dispo['heure_debut'],0,5) ?></td>
                        <td data-label="Fin"><?= substr($dispo['heure_fin'],0,5) ?></td>
                        <td data-label="Statut"><?= $dispo['actif'] ? 'Actif' : 'Inactif' ?></td>
                        <td data-label="Actions">
                            <form method="post" action="" class="prof-inline">
                                <input type="hidden" name="action" value="toggle">
                                <input type="hidden" name="id" value="<?= (int)$dispo['id'] ?>">
                                <button type="submit" class="prof-btn">
                                    <?= $dispo['actif'] ? 'Désactiver' : 'Activer' ?>
                                </button>
                            </form>
                            <form method="post" action="" class="prof-inline"
                                  onsubmit="return confirm('Supprimer cette disponibilité ?')">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= (int)$dispo['id'] ?>">
                                <button type="submit" class="prof-btn">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

                <h2 class="prof-subtitle">Mes cours</h2>
                <table class="prof-table">

                    <tr>
                        <th>Élève</th><th>Email</th><th>Tél. Élève</th><th>Tél. Parent</th>
                        <th>Date</th><th>Durée</th><th>Lieu</th><th>Adresse</th><th>Statut</th><th>Actions</th>
                    </tr>
                    <?php if (!$cours): ?>
                        <tr><td colspan="10">Aucun cours planifié.</td></tr>
                    <?php else: ?>
                        <?php foreach ($cours as $c): ?>
                            <tr>
                                <td data-label="Élève"><?= htmlspecialchars($c['prenom_eleve']." ".$c['nom_eleve']) ?></td>
                                <td data-label="Email"><?= htmlspecialchars($c['email_eleve']) ?></td>
                                <td data-label="Tél. Élève"><?= htmlspecialchars($c['tel_eleve'] ?? '-') ?></td>
                                <td data-label="Tél. Parent"><?= htmlspecialchars($c['tel_parent'] ?? '-') ?></td>
                                <td data-label="Date"><?= date("d/m/Y H:i", strtotime($c['date_cours'])) ?></td>
                                <td data-label="Durée"><?= (int)$c['duree_minutes'] ?> min</td>
                                <td data-label="Lieu"><?= htmlspecialchars($c['lieu']) ?></td>
                                <td data-label="Adresse"><?= htmlspecialchars($c['adresse_cours'] ?? '-') ?></td>
                                <td data-label="Statut"><?= ucfirst($c['statut']) ?></td>
                                <td data-label="Actions">
                                    <?php if ($c['statut'] === 'planifie'): ?>
                                        <form method="post" class="prof-inline">
                                            <input type="hidden" name="action" value="confirme">
                                            <input type="hidden" name="cours_id" value="<?= $c['id'] ?>">
                                            <button type="submit" class="prof-btn">Confirmer</button>
                                        </form>
                                        <form method="post" class="prof-inline"
                                              onsubmit="return confirm('Annuler ce cours ?')">
                                            <input type="hidden" name="action" value="annule">
                                            <input type="hidden" name="cours_id" value="<?= $c['id'] ?>">
                                            <button type="submit" class="prof-btn">Annuler</button>
                                        </form>
                                    <?php else: ?>
                                        —
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>


        </div>