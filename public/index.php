<?php
// Gestione origini start
$allowed_origins = [
    'http://127.0.0.1:5500',
    'http://localhost:8080',
    'https://www.websrl.com/',
    'https://www.electronic.it/',
    'https://22b2.com/'

];

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

if(in_array($origin, $allowed_origins)) {
      header("Access-Control-Allow-Origin: $origin");
      header("Vary: Origin");   
}

header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
// Gestione origini end

require '../vendor/autoload.php';
require __DIR__ . '/../config/env.php';
use brevo_php\app\features\user\BrevoUserComponent;
$blade = require '../src/app/bootstrap/blade.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if ($method === 'POST' ) {
    $recaptcha_token = $_POST['g-recaptcha-response'] ?? '';
    $recaptcha_secret = $_ENV['RECAPTCHA-SECRET'];

function verify($token, $secret) {
    $ch = curl_init('https://www.google.com/recaptcha/api/siteverify');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query([
            'secret' => $secret,
            'response' => $token
        ])
        ]);
        $res = curl_exec($ch);
        curl_close($ch);
        return json_decode($res, true);
};

    if (!verify($recaptcha_token, $recaptcha_secret)['success']) {
        http_response_code(403);
        echo '<p style="color: red;">Clica Non sono un robot prima di inviare</p>';
        exit;
    }

    $data = [
        'nome' => $_POST['nome'] ?? '',
        'cognome' => $_POST['cognome'] ?? '',
        'telefono' => $_POST['telefono'] ?? '' ,
        'email' => $_POST['email'] ?? '',
        'listId' => intval($_POST['listId']),
        'siteName' => $_POST['siteName'],
        'lang' => $_POST['lang']
    ];

echo BrevoUserComponent::handle($data);

} else {
    http_response_code(404);
    echo 'Pagina non trovata';
} 

