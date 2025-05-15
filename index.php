<?php
// index.php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'responsable'){
    header('Location: login.html');
    exit;
}
require 'db.php';
// Récupérer l'ID de l'utilisateur en session
$user_id = (int)$_SESSION['user_id'];

// Requête pour récupérer le nom
$sql = "SELECT nom FROM utilisateurs WHERE id = $user_id LIMIT 1";
if ($result = $mysqli->query($sql)) {
    if ($row = $result->fetch_assoc()) {
        $user_name = htmlspecialchars($row['nom']);
    } else {
        $user_name = 'Responsable';
    }
    $result->free();
} else {
    $user_name = 'Responsable';
}

$sql = "SELECT nom FROM ecoles WHERE id = (SELECT ecole_id FROM responsables_ecole WHERE utilisateur_id=$user_id) LIMIT 1";
if ($result = $mysqli->query($sql)) {
    if ($row = $result->fetch_assoc()) {
        $ecole_name = htmlspecialchars($row['nom']);
    } else {
        $ecole_name = 'Ecole';
    }
    $result->free();
} else {
    $ecole_name = 'Ecole';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
   <!-- Login 9 - Bootstrap Brain Component -->
    <section class="bg-primary py-3 py-md-5 py-xl-8 d-flex align-items-center justify-content-center min-vh-100"> 
        <div class="container"> 
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="#">
                    <img class="img-fluid rounded" loading="lazy" src="assets/img/logo-light.png" width="500" alt="Logo">
                </a>
                
                <button class="btn btn-primary btn-lg">Accueil</button>
                <button id="logout" class="btn btn-primary btn-lg">Se déconnecter</button>
            </nav>
            <div class="row gy-4 align-items-center">
            <div class="col-12">
                <div class="d-flex justify-content-center text-bg-primary">
                <div class="col-12 col-xl-9">
                    <hr class="border-primary-subtle mb-4">
                </div>
                </div>
            </div>
            <div class="col-12 text-bg-primary">
                <h2 class="h1 mb-4">Bienvenue <?php echo $user_name; ?> (<?php echo $ecole_name; ?>)</h2>
                <p class="lead mb-5">Choisisser la matière, pour entrer le stock de matériel.</p>
                <div class="card border-0 rounded-4">
                <div class="card-body p-3 p-md-4 p-xl-5">
                    <div class="row">
                    <div class="col-12">
                        <div class="mb-4">
                        <!-- <h3>Se connecter</h3> -->
                        <!-- <p>Don't have an account? <a href="#!">Sign up</a></p> -->
                        </div>
                    </div>
                    </div>
                    <div id="message"></div>
                    <form id="stockForm">
                    <div class="row gy-3 overflow-hidden">
                        <div class="col-md-4">
                            <label for="matiere" class="form-label">Matière</label>
                            <select id="matiere" class="form-select" required>
                                <option value="">Chargement…</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label for="equipement" class="form-label">Matériel</label>
                            <select id="equipement" class="form-select" required disabled>
                            <option value="">Choisissez d’abord une matière</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="materiel_description" class="form-label">Description</label>
                            <p id="materiel_description"><em><small>
                                
                            </small></em></p>
                        </div>
                        <div class="col-md-12">
                            <label for="stock" class="form-label">Quantité</label>
                            <input type="number" id="stock" class="form-control" required disabled />
                        </div>
                        <div class="col-12">
                        </div>
                        <div class="col-12">
                        </div>
                        <div class="col-12">
                        <div class="d-grid">
                            <button class="btn btn-primary btn-lg" type="submit">Enregistrer</button>
                        </div>
                        </div>
                    </div>
                    </form>
                    <div class="row">
                    <!-- <div class="col-12">
                        <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end mt-4">
                        <a href="#!">Forgot password</a>
                        </div>
                    </div> -->
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </section> 
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function(){
  // Logout
  $('#logout').click(function(){
    $.post('logout.php', function(){
      window.location = 'login.html';
    });
  });

  // Charger les matières
  $.getJSON('get_matieres.php', function(data){
    let sel = $('#matiere').empty()
      .append('<option value="">Sélectionnez une matière</option>');
    data.forEach(m=>{
      sel.append(`<option value="${m.id}">${m.nom}</option>`);
    });
  });

  // Quand matière change → équipements
  $('#matiere').change(function(){
    let mid = this.value;
    $('#equipement').prop('disabled', true).empty();
    $('#stock').prop('disabled',true);
    $('#stockForm button').prop('disabled',true);
    if(!mid) return;

    $.getJSON('get_equipements.php',{matiere_id:mid}, function(data){
      let sel = $('#equipement').empty()
        .append('<option value="">Sélectionnez un matériel</option>');
      data.forEach(e=>{
        sel.append(`<option value="${e.id}">${e.titre}</option>`);
      });
      sel.prop('disabled',false);
    });
  });

  // Quand équipement change → détail + stock courant
$('#equipement').change(function(){
  let eid = this.value;
  if(!eid){
    $('#stock').prop('disabled', true);
    $('#stockForm button').prop('disabled', true);
    $('#materiel_description').html('');  // vider la description
    return;
  }

  $.getJSON('get_detail.php', { equipement_id: eid }, function(data){
    // mettre à jour le stock
    $('#stock')
      .val(data.quantite)
      .prop('disabled', false);

    // injecter la description dans le <p> 
    $('#materiel_description')
      .html('<em><small>' + data.description + '</small></em>');

    // activer le bouton Enregistrer
    $('#stockForm button').prop('disabled', false);
  });
});


    // Soumettre la quantité
    $('#stockForm').submit(function(e){
    e.preventDefault();
    const payload = {
        equipement_id: $('#equipement').val(),
        quantite:     $('#stock').val()
    };

    $.post('update_stock.php', payload, function(resp){
        let msg = $('#message')
        .removeClass('d-none alert-success alert-danger');

        if(resp.status === 'ok'){
        msg.html('<div class="alert alert-success" role="alert">Stock mis à jour!</div>');
        } else {
        msg.html('<div class="alert alert-danger" role="alert">Erreur : '+resp.error+'</div>');
        }
    }, 'json');
    });

});
</script>
</body>
</html>