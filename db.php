<?php
// db.php
$mysqli = new mysqli('localhost','root','root','gestionmaterieluniversitaire');
if($mysqli->connect_errno){
    http_response_code(500);
    exit('DB connection error');
}
