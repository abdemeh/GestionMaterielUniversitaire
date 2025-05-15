<?php
header('Content-Type: application/json');
session_start();

// Database connection
$mysqli = new mysqli('localhost', 'root', 'root', 'gestionmaterieluniversitaire');
if ($mysqli->connect_errno) {
    echo json_encode(['status'=>'error','message'=>'Base de données indisponible']);
    exit;
}

// Retrieve input
$email    = $mysqli->real_escape_string($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

// Fetch user
$query = "SELECT id, mot_de_passe, role FROM utilisateurs WHERE email = '$email' LIMIT 1";
$result = $mysqli->query($query);

if (!$result || $result->num_rows === 0) {
    echo json_encode(['status'=>'error','message'=>'Identifiants incorrects']);
    exit;
}

$user = $result->fetch_assoc();

// Verify password (plain text comparison here; switch to password_verify if hashed)
if ($password !== $user['mot_de_passe']) {
    echo json_encode(['status'=>'error','message'=>'Identifiants incorrects']);
    exit;
}

// Set session and respond
$_SESSION['user_id'] = $user['id'];
$_SESSION['role']    = $user['role'];

echo json_encode([
  'status' => 'success',
  'role'   => $user['role']
]);
