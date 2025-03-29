document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("newCollections");
    const collections = JSON.parse(localStorage.getItem("collections")) || [];
  
    if (collections.length === 0) {
      container.innerHTML += "<p>Nenhuma nova coleção criada ainda.</p>";
      return;
    }
  
    collections.forEach((collection, index) => {
      const bloco = document.createElement("section");
      bloco.classList.add("bloco-lateral");
  
      bloco.innerHTML = `
        <div class="bloco-imagem">
          <img src="${collection.collectionImage}" alt="${collection.titles}" />
        </div>
        <div class="bloco-info">
          <h3>${collection.titles}</h3>
          <p><strong>Autor:</strong> ${collection.author}</p>
          <p><strong>Ano de edição:</strong> ${collection.yearEdition}</p>
          <p><strong>Editor:</strong> ${collection.editor}</p>
          <p><strong>Idioma:</strong> ${collection.language}</p>
          <p><strong>Dimensões:</strong> ${collection.dimensions}</p>
          <p><strong>Encadernação:</strong> ${collection.binding}</p>
          <p><strong>Páginas:</strong> ${collection.pages}</p>
          <p><strong>Descrição:</strong> ${collection.description}</p>
        </div>
      `;
  
      container.appendChild(bloco);
    });
  });
  