document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("newEvents");
    const eventos = JSON.parse(localStorage.getItem("eventos")) || [];
  
    if (eventos.length === 0) {
      container.innerHTML += "<p>Nenhum evento criado ainda.</p>";
      return;
    }
  
    eventos.forEach(evento => {
      const section = document.createElement("section");
      section.classList.add("bloco-lateral");
  
      section.innerHTML = `
        <div class="bloco-imagem">
          <img src="${evento.eventImage}" alt="${evento.title}" />
        </div>
        <div class="bloco-info">
          <h3>${evento.title}</h3>
          <p><strong>Data:</strong> ${evento.date}</p>
          <p><strong>Horário:</strong> ${evento.time}</p>
          <p><strong>Local:</strong> ${evento.location}</p>
          <p><strong>Descrição:</strong> ${evento.description}</p>
        </div>
      `;
  
      container.appendChild(section);
    });
  });
  