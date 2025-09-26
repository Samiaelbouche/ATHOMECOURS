<?php

session_start();

require_once __DIR__ . "/config.php";

/** @var PDO $pdo */


        if (empty($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'professeur') {
            header("Location: ../php/inscriptionprof.php");
            exit;
        }

        $profId = (int)$_SESSION['user_id'];

          $msg = "";


        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $action = $_POST["action"] ?? '';
            $id     = isset($_POST["id"]) ? (int)$_POST["id"] : 0;

            if ($action === "add_dispo") {
                $jour  = $_POST["jour_semaine"] ?? '';
                $debut = $_POST["heure_debut"] ?? '';
                $fin   = $_POST["heure_fin"] ?? '';
                if ($jour && $debut && $fin && $fin > $debut) {
                    $stmt = $pdo->prepare("
                        INSERT INTO disponibilites_prof (professeur_id, jour_semaine, heure_debut, heure_fin)
                        VALUES (:pid, :j, :hd, :hf)
                    ");
                    $stmt->execute([":pid"=>$profId, ":j"=>$jour, ":hd"=>$debut, ":hf"=>$fin]);
                    $msg = " Disponibilité ajoutée";
                } else {
                    $msg = " Vérifiez vos champs";
                }

            } elseif ($action === "toggle" && $id > 0) {
                $stmt = $pdo->prepare("
                    UPDATE disponibilites_prof
                    SET actif = 1 - actif
                    WHERE id=:id AND professeur_id=:pid
                ");
                $stmt->execute([":id"=>$id, ":pid"=>$profId]);
                $msg = "Statut mis à jour";

            } elseif ($action === "delete" && $id > 0) {
                $stmt = $pdo->prepare("
                    DELETE FROM disponibilites_prof
                    WHERE id=:id AND professeur_id=:pid
                ");
                $stmt->execute([":id"=>$id, ":pid"=>$profId]);
                $msg = "🗑 Disponibilité supprimée";

            } elseif ($action === "confirme" && !empty($_POST["cours_id"])) {
                $idCours = (int)$_POST["cours_id"];
                $stmt = $pdo->prepare("
                    UPDATE cours SET statut='confirme'
                    WHERE id=:id AND professeur_id=:pid
                ");
                $stmt->execute([":id"=>$idCours, ":pid"=>$profId]);
                $msg = " Cours confirmé";

            } elseif ($action === "annule" && !empty($_POST["cours_id"])) {
                $idCours = (int)$_POST["cours_id"];
                $stmt = $pdo->prepare("
                    UPDATE cours SET statut='annule'
                    WHERE id=:id AND professeur_id=:pid
                ");
                $stmt->execute([":id"=>$idCours, ":pid"=>$profId]);
                $msg = "Cours annulé";
            }

            header("Location: ".$_SERVER["PHP_SELF"]."?msg=".urlencode($msg));
            exit;
        }

        if (!empty($_GET["msg"])) {
            $msg = $_GET["msg"];
        }


        $stmt = $pdo->prepare("
            SELECT id, jour_semaine, heure_debut, heure_fin, actif
            FROM disponibilites_prof
            WHERE professeur_id = :pid
            ORDER BY FIELD(jour_semaine,'lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche'),
                     heure_debut
        ");
        $stmt->execute([":pid" => $profId]);
        $dispos = $stmt->fetchAll(PDO::FETCH_ASSOC);


        $stmt = $pdo->prepare("
            SELECT c.id, c.date_cours, c.duree_minutes, c.lieu, c.adresse_cours, c.statut,
                   e.nom AS nom_eleve, e.prenom AS prenom_eleve, 
                   e.email AS email_eleve, e.telephone AS tel_eleve, e.telephone_parent AS tel_parent
            FROM cours c
            JOIN eleves e ON e.id = c.eleve_id
            WHERE c.professeur_id = :pid
            ORDER BY c.date_cours ASC
        ");
        $stmt->execute([":pid" => $profId]);
        $cours = $stmt->fetchAll(PDO::FETCH_ASSOC);




        include_once "../views/profilprofview.php";




