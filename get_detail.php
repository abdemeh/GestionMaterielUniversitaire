<?php
// get_detail.php
session_start();
if(!isset($_SESSION['user_id'], $_GET['equipement_id'])) exit;
require 'db.php';

$user   = (int)$_SESSION['user_id'];
$equip  = (int)$_GET['equipement_id'];

// 1) récupérer l'école
$res0 = $mysqli->query(
  "SELECT ecole_id 
     FROM responsables_ecole 
    WHERE utilisateur_id = $user"
);
$ecole = $res0->fetch_object()->ecole_id;

// 2) récupérer stock et description
$sql = "
  SELECT se.quantite, e.description
    FROM equipements e
    LEFT JOIN stock_ecole se
      ON se.ecole_id = $ecole
     AND se.equipement_id = e.id
   WHERE e.id = $equip
   LIMIT 1
";
$res1 = $mysqli->query($sql);
$row  = $res1->fetch_assoc();

header('Content-Type: application/json');
echo json_encode([
  'quantite'    => isset($row['quantite']) ? (int)$row['quantite'] : 0,
  'description' => $row['description'] ?? ''
]);
