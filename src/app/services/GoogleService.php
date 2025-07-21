<?php
namespace brevo_php\app\services;
const GOOGLE_API_URL = 'https://www.google.com/recaptcha/api/siteverify';
 
class GoogleService {
 public static function verify($token, $secret) {
     $ch = curl_init(GOOGLE_API_URL);
     curl_setopt_array($ch, [
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_POST => true,
         CURLOPT_POSTFIELDS => http_build_query([
            'secret' =>  $secret,
            'response' => $token
         ])
         ]);
         $res = curl_exec($ch);
         curl_close($ch);
         return json_decode($res, true);
 }
}