<?php
session_start();
if(!isset($_SESSION['user_id'])) exit;
require 'db.php';

// Récupérer l'école du responsable
$user = (int)$_SESSION['user_id'];
$sql = "
  SELECT m.id, m.nom
    FROM responsables_ecole re
    JOIN ecoles_matieres em ON em.ecole_id=re.ecole_id
    JOIN matieres m ON m.id=em.matiere_id
    WHERE re.utilisateur_id = $user
";
$res = $mysqli->query($sql);
$liste = [];
while($r=$res->fetch_assoc()){
    $liste[] = $r;
}
header('Content-Type: application/json');
echo json_encode($liste);
