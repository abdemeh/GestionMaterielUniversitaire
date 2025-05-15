<?php
// update_stock.php
session_start();
header('Content-Type: application/json');

// Vérifications de base
if (
    !isset($_SESSION['user_id'], $_POST['equipement_id'], $_POST['quantite'])
) {
    echo json_encode(['status'=>'error','error'=>'Données manquantes']);
    exit;
}

require 'db.php';

$user_id = (int)$_SESSION['user_id'];
$equip_id = (int)$_POST['equipement_id'];
$qte = (int)$_POST['quantite'];

// 1) Récupérer l'école liée au responsable
$res = $mysqli->query("
    SELECT ecole_id
      FROM responsables_ecole
     WHERE utilisateur_id = $user_id
    LIMIT 1
");
if (!$res || !$row = $res->fetch_object()) {
    echo json_encode(['status'=>'error','error'=>'Responsable non trouvé']);
    exit;
}
$ecole_id = (int)$row->ecole_id;

// 2) Vérifier si le stock existe déjà
$res2 = $mysqli->query("
    SELECT id
      FROM stock_ecole
     WHERE ecole_id = $ecole_id
       AND equipement_id = $equip_id
    LIMIT 1
");

if ($res2 && $res2->num_rows) {
    // Mise à jour
    $mysqli->query("
        UPDATE stock_ecole
           SET quantite = $qte,
               date_maj = NOW()
         WHERE ecole_id = $ecole_id
           AND equipement_id = $equip_id
    ");
} else {
    // Insertion
    $mysqli->query("
        INSERT INTO stock_ecole
            (ecole_id, equipement_id, quantite, date_maj)
        VALUES
            ($ecole_id, $equip_id, $qte, NOW())
    ");
}

// 3) Retour JSON de résultat
if ($mysqli->error) {
    echo json_encode(['status'=>'error','error'=>$mysqli->error]);
} else {
    echo json_encode(['status'=>'ok']);
}
