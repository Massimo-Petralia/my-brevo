<?php

require '../vendor/autoload.php';
$blade = require '../src/app/bootstrap/blade.php';




$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if ($method === 'POST' ) {
    $data = [
        'nome' => $_POST['nome'] ?? '',
        'cognome' => $_POST['cognome'] ?? '',
        'telefono' => $_POST['telefono'] ?? '' ,
        'email' => $_POST['email'] ?? '',
    ];

echo (require '../src/app/features/user/brevo-user.php')($data);

} else {
    http_response_code(404);
    echo 'Pagina non trovata';
} 

