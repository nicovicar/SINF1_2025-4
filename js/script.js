document.addEventListener("DOMContentLoaded", function () {
  const collectionForm = document.getElementById("collectionForm");

  collectionForm.addEventListener("submit", function (e) {
    e.preventDefault();

    const imageInput = document.getElementById("collectionImage");
    const file = imageInput.files[0];

    if (!file) {
      alert("Por favor, selecione uma imagem.");
      return;
    }

    const reader = new FileReader();

    reader.onload = function (event) {
      const base64Image = event.target.result;

      const collectionData = {
        collectionImage: base64Image, // <--- imagem convertida
        author: document.getElementById("author").value,
        titles: document.getElementById("titles").value,
        yearEdition: document.getElementById("yearEdition").value,
        editor: document.getElementById("editor").value,
        language: document.getElementById("language").value,
        dimensions: document.getElementById("dimensions").value,
        binding: document.getElementById("binding").value,
        pages: document.getElementById("pages").value,
        description: document.getElementById("description").value
      };

      let collections = JSON.parse(localStorage.getItem("collections")) || [];
      collections.push(collectionData);
      localStorage.setItem("collections", JSON.stringify(collections));

      window.location.href = "collections.html";
    };

    reader.readAsDataURL(file); // <- aqui converte a imagem em base64
  });
});
