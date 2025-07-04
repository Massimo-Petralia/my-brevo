<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Conferma invio</title>
  <link rel="stylesheet" href="https://www.tuosito.com/css/stile.css"> <!-- opzionale -->
  <style>
    body { font-family: Arial, sans-serif; text-align: center; padding: 40px; background-color: #f9f9f9; }
    .box { display: inline-block; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px #ccc; }
    .success { color: green; font-weight: bold; }
    .back-btn { margin-top: 20px; display: inline-block; padding: 10px 20px; background: #105990; color: white; text-decoration: none; border-radius: 5px; }
  </style>
</head>
<body>
  <div style="
  font-family: Impact, Haettenschweiler, 'Arial Black', sans-serif;
  font-size: 100px;
  font-weight: bold;
  letter-spacing: -1px;
  color: #32485f;
  text-transform: lowercase;
  line-height: 1;
  margin-bottom: 10px;
  ">
  web
</div>
<div class="box">
    <div class="success" style=" color: {{ $code === 400 ? 'red' : 'green' }}">{{$messaggio}}</div>
    @if ($messaggio === 'Numero WhatsApp non valido')
    <div style="font-size: small; margin-top: 15px">Torna indietro e inserisci un numero WhatsApp valido</div>
    @endif
    <a href="javascript:history.back()" class="back-btn">Torna alla Home</a>
  </div>
</body>
</html>