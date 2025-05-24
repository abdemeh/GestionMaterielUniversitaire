<?php
// download.php
require 'db.php';
require 'vendor/autoload.php'; // Install with: composer require phpoffice/phpspreadsheet

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Security check (adapt to your authentication system)
session_start();
if (!isset($_SESSION['user_id'])) {
    exit('Accès non autorisé.');
}

if (!isset($_GET['ecole_id'])) {
    exit('Paramètre ecole_id manquant.');
}

$ecoleId = $_GET['ecole_id'];

function createSpreadsheet() {
    $spreadsheet = new Spreadsheet();
    $spreadsheet->getProperties()
        ->setCreator("Système de gestion de stock")
        ->setTitle("Export stock équipements");
    return $spreadsheet;
}

// Mode « toutes les écoles »
if ($ecoleId === 'all') {
    $spreadsheet = createSpreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Toutes les écoles');
    
    // Headers
    $sheet->fromArray(
        [['École', 'Matière', 'Équipement', 'Description', 'Quantité', 'Date MAJ']],
        null,
        'A1'
    );

    $row = 2;
    $sql = "SELECT e.id, e.nom, u.nom AS responsable 
            FROM ecoles e
            JOIN responsables_ecole re ON e.id = re.ecole_id
            JOIN utilisateurs u ON re.utilisateur_id = u.id
            ORDER BY e.nom";
    $ecoles = $mysqli->query($sql) or exit('Erreur de récupération des écoles');

    while ($ecole = $ecoles->fetch_assoc()) {
        // Add school header
        $sheet->setCellValue("A{$row}", "École: {$ecole['nom']} - Responsable: {$ecole['responsable']}");
        $sheet->mergeCells("A{$row}:F{$row}");
        $row++;

        // Get school data
        $stmt = $mysqli->prepare("
            SELECT e.nom, m.nom AS matiere, eq.titre, eq.description, 
                   se.quantite, se.date_maj
            FROM stock_ecole se
            JOIN ecoles e ON se.ecole_id = e.id
            JOIN equipements eq ON se.equipement_id = eq.id
            JOIN matieres_equipements me ON eq.id = me.equipement_id
            JOIN matieres m ON me.matiere_id = m.id
            WHERE e.id = ?
            ORDER BY m.nom, eq.titre
        ");
        $stmt->bind_param('i', $ecole['id']);
        $stmt->execute();
        $stock = $stmt->get_result();

        while ($item = $stock->fetch_assoc()) {
            $sheet->fromArray(array_values($item), null, "A{$row}");
            $row++;
        }
        $stmt->close();
        $row++; // Add empty row between schools
    }

    // Auto-size columns
    foreach(range('A','F') as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="stock_complet_' . date('Y-m-d') . '.xlsx"');
    $writer->save('php://output');
    exit;
}

// Mode « une seule école »
$id = (int) $ecoleId;
$stmt = $mysqli->prepare("
    SELECT e.nom AS ecole, u.nom AS responsable 
    FROM responsables_ecole re
    JOIN utilisateurs u ON re.utilisateur_id = u.id
    JOIN ecoles e ON re.ecole_id = e.id
    WHERE e.id = ?
");
$stmt->bind_param('i', $id);
$stmt->execute();
$info = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$info) {
    exit('École ou responsable introuvable.');
}

$spreadsheet = createSpreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle($info['ecole']);

// School info
$sheet->setCellValue('A1', 'École:');
$sheet->setCellValue('B1', $info['ecole']);
$sheet->setCellValue('A2', 'Responsable:');
$sheet->setCellValue('B2', $info['responsable']);

// Headers
$sheet->fromArray(
    [['Matière', 'Équipement', 'Description', 'Quantité', 'État', 'Date MAJ']],
    null,
    'A4'
);

// Data
$stmt = $mysqli->prepare("
    SELECT m.nom AS matiere, eq.titre, eq.description, 
           se.quantite, se.etat, se.date_maj
    FROM stock_ecole se
    JOIN equipements eq ON se.equipement_id = eq.id
    JOIN matieres_equipements me ON eq.id = me.equipement_id
    JOIN matieres m ON me.matiere_id = m.id
    WHERE se.ecole_id = ?
    ORDER BY m.nom, eq.titre
");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();

$row = 5;
while ($data = $res->fetch_assoc()) {
    $sheet->fromArray(array_values($data), null, "A{$row}");
    $row++;
}

// Formatting
$sheet->getStyle('A4:F4')->getFont()->setBold(true);
foreach(range('A','F') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

$writer = new Xlsx($spreadsheet);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="stock_' . mb_substr($info['ecole'], 0, 20) . '_' . date('Y-m-d') . '.xlsx"');
$writer->save('php://output');
exit;
