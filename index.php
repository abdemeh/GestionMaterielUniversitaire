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
                    <img class="img-fluid rounded" loading="lazy" src="assets/img/logo-light.png" width="170" height="80" alt="BootstrapBrain Logo">
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
                <h2 class="h1 mb-4">Bienvenue Ahmed.</h2>
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
                    <div class="alert alert-success" role="alert">
                        Enregistré!
                    </div>
                    <form action="#!">
                    <div class="row gy-3 overflow-hidden">
                        <div class="col-md-4">
                            <label for="matiere" class="form-label">Matière</label>
                            <select id="matiere" class="form-select" required>
                                <option value="informatique">Études sociales</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label for="materiel" class="form-label">Matériel</label>
                            <select id="materiel" class="form-select" required>
                                <option value="Carte du Maroc naturel et economique">Carte du Maroc naturel et economique</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="materiel_description" class="form-label">Description</label>
                            <p id="materiel_description"><em><small>
                                Carte du Maroc naturel et economique
                                • En langue arabe Avec frontieres officielles
                                • Echelle 1/1500000
                                · Format minimum 9Scmx110 cm, maximum 100x120 cm
                                Descriptif
                                • lmprimee en recto verso ou recto seulement (une pour le Maroc nature! et l'autre pour le Maroc economique) en
                                quadrichromie sur tissus plastifie recto et verso indechirable et antireflet permettant l'ecriture a la craie et au marqueur
                                avec un effacement facile
                                • Munie de deux ceillets de suspension
                                · Conforme aux programmes officiels et aux recommandations pedagogiques
                                • Realisees selon les normes scientifiques (titre, echelle, legende, couleurs, symboles, orientations, et termes internationaux)
                                • Bonne qualite d'impression et mise en page
                                • Echelle (lineaire) et titre de la carte places dans un endroit convenable
                                • Utilisation de plusieurs formes de corps calligraphiques pour indiquer et nommer les differents types d'aspects
                                geographiques
                                • Actualisation des donnees geographiques et statistiques datees
                            </small></em></p>
                        </div>
                        <div class="col-md-12">
                            <label for="stock" class="form-label">Quantité en stock</label>
                            <input type="number" id="stock" class="form-control" placeholder="Entrez la quantité" required>
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
</body>
</html>