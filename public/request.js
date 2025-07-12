
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('brevoForm');
  const output = document.getElementById('risultato');

  form.addEventListener('submit', function (e) {
    e.preventDefault(); // blocca il comportamento normale
   
    const recaptchaResponse = grecaptcha.getResponse();
    
     if (!recaptchaResponse) {
      output.innerHTML = '<p style="color: red;">Clica Non sono un robot prima di inviare</p>'
      return;
   }
    
    const formData = new FormData(form);
    formData.append('g-recaptcha-response', recaptchaResponse);

    fetch('https://www.websrl.com/brevo_php/public/index.php', {
      method: 'POST',
      body: formData
    })
    .then(response => {
      if (!response.ok) throw new Error('Errore nella risposta');
      return response.text();
    })
    .then(html => {
      output.innerHTML = html;
    })
    .catch(err => {
      output.innerHTML = '<p>Errore durante l’invio</p>';
      });
  });
});
