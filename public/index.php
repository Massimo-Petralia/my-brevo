<?php
require '../vendor/autoload.php';
use brevo_php\app\features\user\BrevoUserComponent;
$blade = require '../src/app/bootstrap/blade.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if(!empty($_POST['fakeUrl'])){
    $fakeData = $_POST['fakeUrl'];
    $log = 'Accesso negato : Possibile bot rilevato : ';
    file_put_contents( __DIR__.'/../log/brevo_user_log.txt', $log . $fakeData, FILE_APPEND);
    exit($log);
}

if ($method === 'POST' ) {
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

