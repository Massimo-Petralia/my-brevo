<?php
namespace brevo_php\app\helper;
require __DIR__ . '/../../../config/env.php';

class SecurityHelper {

    private array $recaptchaSecrets;

    public function __construct() 
    {
       $this->recaptchaSecrets =  [
    'web' => $_ENV['RECAPTCHA-SECRET-WEB'],
    '22b2' => $_ENV['RECAPTCHA-SECRET-22B2'],
    'local' => $_ENV['RECAPTCHA-SECRET-LOCALHOST']
    ]; 
    }

   public function setSecret ($origin) {

    if(in_array($origin, 
    [
        'https://22b2.com',
        'https://22b2.com/en'
    ]
    ,true)) {
        return $this->recaptchaSecrets['22b2'];
    }
    if($origin === 'http://localhost:8000') {
        return $this->recaptchaSecrets['local'];
    }
    return $this->recaptchaSecrets['web'];
}

}