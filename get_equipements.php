<?php
session_start();
if(!isset($_SESSION['user_id'],$_GET['matiere_id'])) exit;
require 'db.php';

$id = (int)$_GET['matiere_id'];
$sql = "
  SELECT e.id, e.titre
    FROM matieres_equipements me
    JOIN equipements e ON e.id=me.equipement_id
    WHERE me.matiere_id = $id
";
$res = $mysqli->query($sql);
$out = [];
while($r=$res->fetch_assoc()){
    $out[] = $r;
}
header('Content-Type: application/json');
echo json_encode($out);
