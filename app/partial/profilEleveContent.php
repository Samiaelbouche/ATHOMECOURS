<div class="prof-profile">
    <h2 class="prof-title">Profil élève</h2>
    <p class="prof-welcome">
        Bonjour <?= htmlspecialchars($_SESSION["user_prenom"] ?? '') . " " . htmlspecialchars($_SESSION["user_nom"] ?? '') ?>
    </p>
</div>

    <div class="center">
      <h2 class="prof-profile">Créneaux disponibles</h2>
        <?php if (empty($dispos)): ?>
            <div class="eleve-empty">Aucun créneau disponible.</div>
            <?php else: ?>
            <table class="eleve-table">
                <tr><th>Professeur</th><th>Jour</th><th>Heure</th><th>Action</th></tr>
                <?php foreach ($dispos as $d): ?>
                    <tr>
                        <td><?= htmlspecialchars($d['prenom'].' '.$d['nom']) ?></td>
                        <td><?= ucfirst($d['jour_semaine']) ?></td>
                        <td><?= htmlspecialchars($d['heure_debut'].' - '.$d['heure_fin']) ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="action" value="reserver">
                                <input type="hidden" name="dispo_id" value="<?= (int)$d['id'] ?>">
                                <input type="date" name="date_cours" required>
                                <select name="lieu">
                                    <option value="en_ligne">En ligne</option>
                                    <option value="domicile">À domicile</option>
                                </select>
                                <input type="text" name="adresse_cours" placeholder="Adresse (si domicile)">
                                <button type="submit">Réserver</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>

            <h2 class="prof-profile">Mes cours</h2>
            <?php if (empty($cours)): ?>
                <div class="eleve-empty">Aucun cours réservé.</div>
            <?php else: ?>
            <table class="eleve-table">
                <tr><th>Date</th><th>Professeur</th><th>Lieu</th><th>Statut</th><th>Action</th></tr>
                <?php foreach ($cours as $c): ?>
                    <tr>
                        <td><?= date("d/m/Y H:i", strtotime($c['date_cours'])) ?></td>
                        <td><?= htmlspecialchars($c['prenom_prof'].' '.$c['nom_prof']) ?></td>
                        <td><?= ucfirst($c['lieu']) ?></td>
                        <td><?= ucfirst($c['statut']) ?></td>
                        <td>
                            <?php if ($c['statut'] === 'planifie'): ?>
                                <?php if (isset($c['prix'])): ?>
                                    <?= number_format((float)$c['prix'], 2, ',', ' ') ?> €
                                <?php endif; ?>
                                <a href="../paiement/paiement.php?cours_id=<?= (int)$c['id'] ?>">Payer</a>
                            <?php elseif ($c['statut'] === 'confirme'): ?>
                                <span class="btn-disabled">Confirmé</span>
                            <?php else: ?>
                                <span class="btn-disabled"><?= ucfirst($c['statut']) ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
