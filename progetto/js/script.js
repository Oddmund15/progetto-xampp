document.addEventListener('DOMContentLoaded', function() {
    // Imposta l'anno corrente nel footer
    document.getElementById('current-year').textContent = new Date().getFullYear();
    
    // Validazione lato client per il form di registrazione
    const registrationForm = document.getElementById('registration-form');
    if (registrationForm) {
        registrationForm.addEventListener('submit', function(e) {
            let valid = true;
            
            // Validazione nome
            const nome = document.getElementById('nome');
            if (nome.value.trim() === '') {
                showError('Il nome è obbligatorio');
                valid = false;
            }
            
            // Validazione cognome
            const cognome = document.getElementById('cognome');
            if (cognome.value.trim() === '') {
                showError('Il cognome è obbligatorio');
                valid = false;
            }
            
            // Validazione data di nascita
            const dataNascita = document.getElementById('data_nascita');
            if (!dataNascita.value) {
                showError('La data di nascita è obbligatoria');
                valid = false;
            }
            
            // Validazione email
            const email = document.getElementById('email');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email.value)) {
                showError('Inserisci un indirizzo email valido');
                valid = false;
            }
            
            // Validazione corso
            const corso = document.getElementById('corso');
            if (corso.value.trim() === '') {
                showError('Il corso è obbligatorio');
                valid = false;
            }
            
            if (!valid) {
                e.preventDefault();
            }
        });
    }
});

function showError(message) {
    const errorDiv = document.getElementById('error-message');
    errorDiv.textContent = message;
    errorDiv.style.display = 'block';
    
    // Nascondi il messaggio dopo 5 secondi
    setTimeout(() => {
        errorDiv.style.display = 'none';
    }, 5000);
}