document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formRegistrazione");
    if (form) {
      form.addEventListener("submit", function (e) {
        e.preventDefault();
  
        const nome = document.getElementById("nome").value.trim();
        const cognome = document.getElementById("cognome").value.trim();
        const nascita = document.getElementById("nascita").value;
        const email = document.getElementById("email").value.trim();
        const corso = document.getElementById("corso").value;
  
        const errore = document.getElementById("errore");
        errore.textContent = "";
  
        if (!nome || !cognome || !nascita || !email || !corso) {
          errore.textContent = "Tutti i campi sono obbligatori.";
          return;
        }
  
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
          errore.textContent = "Email non valida.";
          return;
        }
  
        const studente = { nome, cognome, nascita, email, corso };
  
        const studenti = JSON.parse(localStorage.getItem("students")) || [];
        studenti.push(studente);
        localStorage.setItem("students", JSON.stringify(studenti));
  
        alert("Studente registrato con successo!");
        window.location.href = "index.html";
      });
    }
  });
  