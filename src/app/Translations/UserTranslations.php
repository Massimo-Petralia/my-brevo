<?php

namespace brevo_php\app\Translations;

class UserTranslations {
     public static function get(): array {
        return [
  'eng' => [
    "Unable to create contact, SMS is already associated with another Contact" =>
    "Unable to create contact, WhatsApp is already associated with another Contact",

  ],
  'ita' => [
    //"Registration successful!" => "Registrazione avvenuta con successo !",
    "Invalid phone number" => "Numero WhatsApp non valido",
    "Unable to create contact, SMS is already associated with another Contact" =>
    "Impossibile creare il contatto, il numero WhatsApp è già associato a un altro contatto",
    
  ],
];
     }
}

