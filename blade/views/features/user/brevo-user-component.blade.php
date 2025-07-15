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

    .box {
      display: inline-block;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px #ccc;
      max-width: 90vw;
      margin-top: 10px
    }
    .success {
      font-size: 2vw; /* adattivo */
      color: green;
      font-weight: bold;
    }
    .info {
      font-size: 3.5vw;
      margin-top: 15px;
    }


    @media(min-width: 600px) {
      .success { font-size: 14px; }
      .info { font-size: 16px; }
    }


  </style>
</head>
<body>

  <div class="box">
    <div class="success" style="color: {{ $code === 400 ? 'red' : 'green' }}">
      {{$messaggio}}
    </div>
    @if ($code === 'Numero WhatsApp non valido' )
    <div class="info">
      {{$info}}
    </div>
    @endif
  </div>
</body>
</html>
