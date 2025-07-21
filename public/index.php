<?php
$allowed_origins = [
    'http://127.0.0.1:5500',
    'http://localhost:8000',
    'https://www.websrl.com',
    'https://www.electronic.it',
    'https://22b2.com',
    'https://22b2.com/en'

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

require '../vendor/autoload.php';
use brevo_php\app\features\user\BrevoUserComponent;
use brevo_php\app\helper\SecurityHelper;
use brevo_php\app\services\GoogleService;
$blade = require '../src/app/bootstrap/blade.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if ($method === 'POST' ) {
    $origin = $_SERVER['HTTP_ORIGIN'];
     $recaptcha_token = $_POST['g-recaptcha-response'] ?? '';

     $securityHelper = new SecurityHelper();
     $response = GoogleService::verify($recaptcha_token, $recaptcha_secret = $securityHelper->setSecret($origin));

    if (empty($response['success']) || !$response['success']) {
         http_response_code(403);
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

