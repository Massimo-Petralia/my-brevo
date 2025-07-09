<?php
namespace brevo_php\app\features\user;
use brevo_php\app\services\BrevoService;
use brevo_php\app\helper\GenericHelper;

// GET CONTACT
function getContact($email)
{
    $response = BrevoService::brevoRequest('GET', '/contacts/'.urlencode($email));
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

    $response = BrevoService::brevoRequest('POST', '/contacts', $payload);

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

    $response = BrevoService::brevoRequest('PUT', '/contacts/'.urlencode($email), $payload);
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