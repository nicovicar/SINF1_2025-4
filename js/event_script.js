document.addEventListener("DOMContentLoaded", function () {
    const eventForm = document.getElementById("eventForm");
  
    eventForm.addEventListener("submit", function (e) {
      e.preventDefault();
  
      const file = document.getElementById("eventImage").files[0];
      if (!file) {
        alert("Por favor, selecione uma imagem.");
        return;
      }
  
      const reader = new FileReader();
      reader.onload = function (event) {
        const base64Image = event.target.result;
  
        const eventData = {
          eventImage: base64Image,
          title: document.getElementById("title").value,
          date: document.getElementById("date").value,
          time: document.getElementById("time").value,
          location: document.getElementById("location").value,
          description: document.getElementById("description").value
        };
  
        let eventos = JSON.parse(localStorage.getItem("eventos")) || [];
        eventos.push(eventData);
        localStorage.setItem("eventos", JSON.stringify(eventos));
  
        window.location.href = "eventos.html";
      };
  
      reader.readAsDataURL(file);
    });
  });
  