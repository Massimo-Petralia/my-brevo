document.addEventListener('DOMContentLoaded', function (e) {
e.preventDefault();
  var form = document.getElementById('brevoForm');
  var output = document.getElementById('risposta');

  if (form && output) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var data = new FormData(form);
      var result = {};
      for (var pair of data.entries()) {
        result[pair[0]] = pair[1];
      }
      setTimeout(function () {
        output.textContent = 'Iscrizione completata per ' + result.nome + ' ' + result.cognome + '. Email: ' + result.email + ' - Tel: ' + result.telefono;
      }, 500);
    });
  }
});