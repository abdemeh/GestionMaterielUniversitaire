<?php
require 'db.php';
session_start();

if (!isset($_GET['equipement_id'])) {
    exit(json_encode(['error' => 'Paramètre manquant']));
}

$user_id = (int)$_SESSION['user_id'];
$equip_id = (int)$_GET['equipement_id'];

// Récupérer l'école du responsable
$res = $mysqli->query("
    SELECT ecole_id 
    FROM responsables_ecole 
    WHERE utilisateur_id = $user_id 
    LIMIT 1
");

if (!$res || !$row = $res->fetch_object()) {
    exit(json_encode(['error' => 'Responsable non trouvé']));
}
$ecole_id = (int)$row->ecole_id;

// Requête pour récupérer le stock ET l'état
$stmt = $mysqli->prepare("
    SELECT 
        eq.description,
        se.quantite,
        se.etat 
    FROM stock_ecole se
    JOIN equipements eq ON se.equipement_id = eq.id
    WHERE se.ecole_id = ?
      AND se.equipement_id = ?
    LIMIT 1
");

$stmt->bind_param('ii', $ecole_id, $equip_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows) {
    $row = $result->fetch_assoc();
    echo json_encode([
        'description' => $row['description'],
        'quantite' => $row['quantite'],
        'etat' => $row['etat'] // Ajout de l'état
    ]);
} else {
    echo json_encode([
        'description' => 'Aucune description disponible',
        'quantite' => 0,
        'etat' => null
    ]);
}
?>
