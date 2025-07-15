
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('brevoForm');
  const output = document.getElementById('risultato');
  const lang = document.getElementById('lang')

  form.addEventListener('submit', function (e) {
    e.preventDefault(); // blocca il comportamento normale
   
    const recaptchaResponse = grecaptcha.getResponse();
    
      if (!recaptchaResponse) {
        const langValue  = lang.value 
        if(langValue === 'ita') {
          output.innerHTML = '<p style="color: red;">Clica Non sono un robot prima di inviare</p>'
        }
        if(langValue === 'eng') {
          output.innerHTML = '<p style="color: red;">Click I\'m not a robot before submitting.</p>'

        }
       return;
   }
    
    const formData = new FormData(form);
    formData.append('g-recaptcha-response', recaptchaResponse);
    grecaptcha.reset();


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
      output.innerHTML = '<p style="color: red;">Clica Non sono un robot prima di inviare</p>';
      console.error('error log: ' + err);
      });
  });
});
