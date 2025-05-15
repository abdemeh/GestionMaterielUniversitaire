<?php
// get_summary.php
header('Content-Type: application/json');
require 'db.php';

$out = [];

// 1. Nombre d'établissements
$r = $mysqli->query("SELECT COUNT(*) AS c FROM ecoles")->fetch_object()->c;
$out[] = ['label'=>'Établissements','icon'=>'fa-university','count'=>$r];

// 2. Nombre de responsables
$r = $mysqli->query("SELECT COUNT(*) AS c FROM utilisateurs WHERE role='responsable'")
             ->fetch_object()->c;
$out[] = ['label'=>'Responsables','icon'=>'fa-users','count'=>$r];

// 3. Nombre d'équipements
$r = $mysqli->query("SELECT COUNT(*) AS c FROM equipements")->fetch_object()->c;
$out[] = ['label'=>'Équipements','icon'=>'fa-cogs','count'=>$r];

// 4. Stock total (somme de toutes les quantités)
$r = $mysqli->query("SELECT COALESCE(SUM(quantite),0) AS c FROM stock_ecole")
             ->fetch_object()->c;
$out[] = ['label'=>'Stock total','icon'=>'fa-bar-chart','count'=>$r];

echo json_encode($out);
