document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("form");
    
  
    form.addEventListener("submit", async function (event) {
      event.preventDefault();
        
      const formData = new FormData(form);
      for (const pair of formData.entries()) {
        console.log(`${pair[0]}: ${pair[1]}`);
      }
      await fetch(`/api/niveaux/store`, {
        method: "POST",
        body: formData,
      }).then(async (response) => {
        if (response.ok) {
          console.log("Formulaire soumis avec succès !");
          window.location.href = `/niveaux`;
        } else {
          console.error("Erreur lors de la soumission du formulaire.");
          const errorText = await response.text();
          console.error(errorText);
        }
      });
    });

    
  
  });