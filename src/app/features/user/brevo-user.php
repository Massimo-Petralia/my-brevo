
<?php
require_once __DIR__ . '/../../bootstrap/blade.php';
require __DIR__ . '../../../../../config/env.php';

// CONFIG
const LIST_ID = 21;
const API_BASE_URL = 'https://api.brevo.com/v3';
const BREVO_LOG_PATH = '../brevo/log/brevo_user_log.txt';

// NORMALIZZA TELEFONO
function normalizzaTelefono($numero) {
    // Rimuove spazi, trattini e altri simboli
    $numero = preg_replace('/[^0-9+]/', '', $numero);

    // Se inizia con "00", sostituisce con "+"
    if (strpos($numero, '00') === 0) {
        $numero = '+' . substr($numero, 2);
    }

    // Se inizia con "3" e ha 10 cifre, aggiunge +39
    if (preg_match('/^3\d{9}$/', $numero)) {
        $numero = '+39' . $numero;
    }

   

    return $numero;
}

// CURL WRAPPER
function brevoRequest($method, $endpoint, $payload = null)
{
    $ch = curl_init(API_BASE_URL.$endpoint);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
            'Content-Type: application/json',
            'api-key: '. $_ENV['BREVO_API_KEY'],
        ],
    ]);

    if ($payload) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    }

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return ['code' => $httpCode, 'body' => json_decode($response, true)];
}

// GET CONTACT
function getContact($email)
{
    $response = brevoRequest('GET', '/contacts/'.urlencode($email));
    logBrevoResponse('GET', $email, $response);
    return $response;
}

// CREATE CONTACT
function createContact($data)
{
    $payload = [
        'email' => $data['email'],
        'attributes' => [
            'NOME' => $data['nome'],
            'COGNOME' => $data['cognome'],
	    'SMS' => $data['telefono'],
            'WHATSAPP' => $data['telefono'],
        ],
        'listIds' => [$data['listId']],
        'updateEnabled' => false,
    ];

    $response = brevoRequest('POST', '/contacts', $payload);
    logBrevoResponse('POST', $data['email'], $response);
    return $response;
}

// UPDATE CONTACT
function updateContact($email, $data)
{
    $payload = [
        'attributes' => [
            'NOME' => $data['nome'],
            'COGNOME' => $data['cognome'],
            'SMS' => $data['telefono'],
            'WHATSAPP' => $data['telefono'],
        ],
        'listIds' => [$data['listId']],
    ];

    $response = brevoRequest('PUT', '/contacts/'.urlencode($email), $payload);
    logBrevoResponse('PUT', $email, $response);
    return $response;
}



// MAIN SYNC FUNCTION
function syncContact($formData)
{
    $check = getContact($formData['email']);

    if ($check['code'] === 404) {
        return createContact($formData);
    } elseif ($check['code'] === 200) {
        return updateContact($formData['email'], $formData);
    } else {
        return ['error' => 'Errore nella verifica contatto', 'dettagli' => $check];
    }
}

// Funzione di log
function logBrevoResponse($type, $email, $response) {
    $log = sprintf(
        "[%s] %s | Email: %s | Codice: %s | Risposta: %s\n",
        date('Y-m-d H:i:s'),
        strtoupper($type),
        $email,
        $response['code'],
        json_encode($response['body'])
    );
    file_put_contents(BREVO_LOG_PATH, $log, FILE_APPEND);
}

// === LOGICA DI ESECUZIONE DEL FORM (CONTROLLER) ===
return function (array $formData) {
    $formData['telefono'] = normalizzaTelefono($formData['telefono']);
    $response = syncContact($formData);
    $blade = blade();
   // dump($response);
    $code = $response['code'];
    $message = $response['body']['message'];
    $siteName = $formData['siteName'];

    if($code === 201) {
        $message = 'Registrazione avvenuta con successo !';
    }
    if($code === 204) {
        $message = 'Contatto aggiornato con successo !';
    }

    if($message === 'Invalid phone number') {
        $message = 'Numero WhatsApp non valido';
    }

    return $blade->render('features.user.brevo-user',['code' => $code,'messaggio' => $message, 'siteName' => $siteName]);
};





