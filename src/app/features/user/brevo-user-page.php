<?php
namespace brevo_php\app\features\user;
require __DIR__ . '../../../../../config/env.php';
use brevo_php\app\helper\GenericHelper;

const LIST_ID = 21;
const API_BASE_URL = 'https://api.brevo.com/v3';

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
    GenericHelper::logBrevoResponse('GET', $email, $response);
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

    GenericHelper::logBrevoResponse('POST', $data['email'], $response);
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
    GenericHelper::logBrevoResponse('PUT', $email, $response);
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









