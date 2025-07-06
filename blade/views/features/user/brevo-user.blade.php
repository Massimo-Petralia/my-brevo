<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- fondamentale per mobile -->
  <title>Conferma invio</title>
  <link rel="stylesheet" href="https://www.tuosito.com/css/stile.css"> <!-- opzionale -->
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      padding: 20px;
      background-color: #f9f9f9;
      margin: 0;
    }
    .logo {
      font-family: Impact, Haettenschweiler, 'Arial Black', sans-serif;
      font-size: 16vw; /* adattivo */
      font-weight: bold;
      letter-spacing: -1px;
      color: #32485f;
      text-transform: lowercase;
      line-height: 1;
      margin-bottom: 20px;
    }
    .box {
      display: inline-block;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px #ccc;
      max-width: 90vw;
    }
    .success {
      font-size: 5vw; /* adattivo */
      color: green;
      font-weight: bold;
    }
    .info {
      font-size: 3.5vw;
      margin-top: 15px;
    }
    .back-btn {
      margin-top: 20px;
      display: inline-block;
      padding: 10px 20px;
      background: #105990;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-size: 4vw;
    }

    @media(min-width: 600px) {
      .logo { font-size: 96px; }
      .success { font-size: 24px; }
      .info { font-size: 16px; }
      .back-btn { font-size: 16px; }
    }
  </style>
</head>
<body>
  <div class="logo">
    {{$siteName}}
  </div>
  <div class="box">
    <div class="success" style="color: {{ $code === 400 ? 'red' : 'green' }}">
      {{$messaggio}}
    </div>
    @if ($messaggio === 'Numero WhatsApp non valido')
    <div class="info">
      Torna indietro e inserisci un numero WhatsApp valido
    </div>
    @endif
    <a href="javascript:history.back()" class="back-btn">Torna alla Home</a>
  </div>
</body>
</html>
