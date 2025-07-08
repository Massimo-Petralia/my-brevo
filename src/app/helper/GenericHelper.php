<?php
namespace brevo_php\app\helper;
const BREVO_LOG_PATH = __DIR__ . '/../../../log/brevo_user_log.txt';
class GenericHelper {
    public static function normalizzaTelefono($numero) {
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

public static function logBrevoResponse($type, $email, $response) {
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

}