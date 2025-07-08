<?php
namespace brevo_php\app\features\user;
require_once __DIR__ . '/brevo-user-page.php';
use function brevo_php\app\features\user\syncContact;
use brevo_php\app\helper\GenericHelper;
use brevo_php\app\Translations\UserTranslations;
use function brevo_php\app\bootstrap\blade;

class BrevoUserComponent {
   public static function handle(array $formData)  {
    $formData['telefono'] = GenericHelper::normalizzaTelefono($formData['telefono']);

    $response = syncContact($formData);

    $langKey = $formData['lang'] === 'eng' ? 'eng' : 'ita';
    $siteName = $formData['siteName'];
    $blade = blade();

    $code = $response['code'];
    $message = $response['body']['message'];
    $buttonText = 'Torna alla home';
    $info = 'Torna indietro e inserisci un numero WhatsApp valido';

    if ($code === 201) {
        $message = 'Registrazione avvenuta con successo !';
        if ($langKey === 'eng') {
            $message = 'Registration successful!';
        }
    }

    if ($code === 204) {
        $message = 'Contatto aggiornato con successo !';
        if ($langKey === 'eng') {
            $message = 'Contact updated successfully !';
        }
    }

    $translations = UserTranslations::get();
    if (isset($translations[$langKey][$message])) {
        $message = $translations[$langKey][$message];
    }

    if ($langKey === 'eng') {
        $buttonText = 'Back to home';
        $info = 'Go back and enter a valid WhatsApp number';
    }

    return $blade->render('features.user.brevo-user-component', [
        'code' => $code,
        'messaggio' => $message,
        'siteName' => $siteName,
        'buttonText' => $buttonText,
        'info' => $info
    ]);
}

}