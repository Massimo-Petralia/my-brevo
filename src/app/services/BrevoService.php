<?php
namespace brevo_php\app\services;
require __DIR__ . '../../../../config/env.php';
const BREVO_API_BASE_URL = 'https://api.brevo.com/v3';
class BrevoService {

   public static function brevoRequest($method, $endpoint, $payload = null)
{
    $ch = curl_init(BREVO_API_BASE_URL.$endpoint);
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

}