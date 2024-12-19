document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("form");
    const ProfesseurSelect = document.getElementById("professeur-select");
    const moduleSelect = document.getElementById("module-select");
    loadSelectProfesseur(ProfesseurSelect);
    loadSelectModule(moduleSelect);
  
    
  
    function loadSelectProfesseur(ProfesseurSelect) {
      fetch(`/api/professeur`)
        .then((response) => response.json())
        .then((data) => {
            ProfesseurSelect.innerHTML = "";
          data.professeurs.forEach((professeur) => {
            ProfesseurSelect.innerHTML += `
                <option value="${professeur.id}">${professeur.prenom}</option>
                `;
          });
        });
    }

    function loadSelectModule(moduleSelect) {
        fetch(`/api/module`)
          .then((response) => response.json())
          .then((data) => {
            moduleSelect.innerHTML = "";
            data.modules.forEach((module) => {
                moduleSelect.innerHTML += `
                  <option value="${module.id}">${module.nom}</option>
                  `;
            });
          });
      }
  
        form.addEventListener("click", async function (event) {
          event.preventDefault();
          await fetch(`/api/cours/store`, {
            method: "POST",
          }).then(async (response) => {
            if (response.ok) {
              console.log("Formulaire soumis avec succès !");
              window.location.href = `/cours`;
            } else {
              console.error("Erreur lors de la soumission du formulaire.");
              const errorText = await response.text();
              console.error(errorText);
            }
          });
          loadSelectProfesseur(ProfesseurSelect);
            loadSelectModule(moduleSelect);
        });
  
    
  

  
    
  
  });