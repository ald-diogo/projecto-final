document.addEventListener("DOMContentLoaded", function () {
    // Carregar dados de exemplo (será substituído por requisições ao banco de dados)
    const livros = [
      { titulo: "Livro A", autor: "Autor A", categoria: "Ficção", disponivel: 10 },
      { titulo: "Livro B", autor: "Autor B", categoria: "Terror", disponivel: 5 }
    ];
  
    const livrosTableBody = document.getElementById("livros-table-body");
    livros.forEach(livro => {
      const row = `
        <tr>
          <td>${livro.titulo}</td>
          <td>${livro.autor}</td>
          <td>${livro.categoria}</td>
          <td>${livro.disponivel}</td>
          <td>
            <button class="btn btn-warning btn-sm">Editar</button>
            <button class="btn btn-danger btn-sm">Excluir</button>
          </td>
        </tr>
      `;
      livrosTableBody.innerHTML += row;
    });
  });