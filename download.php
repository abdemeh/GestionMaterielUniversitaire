<?php
// download.php
require 'db.php';

if (!isset($_GET['ecole_id'])) {
    exit('Paramètre ecole_id manquant.');
}
$ecoleId = $_GET['ecole_id'];

// helper pour les en-têtes CSV
function openCsv(string $name)
{
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $name . '"');
    return fopen('php://output', 'w');
}

// Mode « toutes les écoles »
if ($ecoleId === 'all') {
    $out = openCsv('stock_all_ecoles.csv');

    // On ajoute 'description' dans les entêtes
    fputcsv($out, ['ecole', 'matiere', 'equipement', 'description', 'quantité', 'date MAJ'], ';');

    $sql = "
      SELECT e.id, u.nom AS responsable
      FROM ecoles e
      JOIN responsables_ecole re ON e.id = re.ecole_id
      JOIN utilisateurs u ON re.utilisateur_id = u.id
      ORDER BY e.nom
    ";
    $all = $mysqli->query($sql) or exit('Erreur de récupération des écoles');

    while ($row = $all->fetch_assoc()) {
        // Ligne de responsable
        fwrite($out, "Responsable: {$row['responsable']}\n");

        $stmt = $mysqli->prepare("
          SELECT 
            e.nom        AS ecole,
            m.nom        AS matiere,
            eq.titre     AS equipement,
            eq.description,
            se.quantite,
            se.date_maj
          FROM stock_ecole se
          JOIN ecoles e              ON se.ecole_id = e.id
          JOIN equipements eq        ON se.equipement_id = eq.id
          JOIN matieres_equipements me ON eq.id      = me.equipement_id
          JOIN matieres m            ON me.matiere_id = m.id
          WHERE e.id = ?
          ORDER BY m.nom, eq.titre
        ");
        $stmt->bind_param('i', $row['id']);
        $stmt->execute();
        $stock = $stmt->get_result();

        while ($s = $stock->fetch_assoc()) {
            fputcsv($out, [
                $s['ecole'],
                $s['matiere'],
                $s['equipement'],
                $s['description'],
                $s['quantite'],
                $s['date_maj']
            ], ';');
        }
        $stmt->close();
    }

    fclose($out);
    exit;
}

// Mode « une seule école »
$id = (int) $ecoleId;
$stmt = $mysqli->prepare("
  SELECT u.nom AS responsable
  FROM responsables_ecole re
  JOIN utilisateurs u ON re.utilisateur_id = u.id
  WHERE re.ecole_id = ?
");
$stmt->bind_param('i', $id);
$stmt->execute();
$info = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$info) {
    exit('École ou responsable introuvable.');
}

$out = openCsv("stock_ecole_{$id}.csv");

// Responsable en première ligne
fwrite($out, "Responsable: {$info['responsable']}\n");

// Entêtes avec 'description'
fputcsv($out, ['ecole', 'matiere', 'equipement', 'description', 'quantité', 'date MAJ'], ';');

$stmt = $mysqli->prepare("
  SELECT 
    e.nom        AS ecole,
    m.nom        AS matiere,
    eq.titre     AS equipement,
    eq.description,
    se.quantite,
    se.date_maj
  FROM stock_ecole se
  JOIN ecoles e              ON se.ecole_id = e.id
  JOIN equipements eq        ON se.equipement_id = eq.id
  JOIN matieres_equipements me ON eq.id      = me.equipement_id
  JOIN matieres m            ON me.matiere_id = m.id
  WHERE e.id = ?
  ORDER BY m.nom, eq.titre
");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();

while ($r = $res->fetch_assoc()) {
    fputcsv($out, [
        $r['ecole'],
        $r['matiere'],
        $r['equipement'],
        $r['description'],
        $r['quantite'],
        $r['date_maj']
    ], ';');
}

fclose($out);
exit;
?>
