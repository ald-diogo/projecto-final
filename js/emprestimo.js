document.addEventListener("DOMContentLoaded", function () {
    // Dados de exemplo (serão substituídos por requisições ao banco de dados)
    const emprestimos = [
      { usuario: "João Silva", livro: "Livro A", dataEmprestimo: "2025-01-10", dataDevolucao: "2025-01-20", status: "Ativo" },
      { usuario: "Maria Oliveira", livro: "Livro B", dataEmprestimo: "2025-01-15", dataDevolucao: "2025-01-25", status: "Atrasado" },
    ];
  
    const emprestimosTableBody = document.getElementById("emprestimos-table-body");
    emprestimos.forEach(emprestimo => {
      const row = `
        <tr>
          <td>${emprestimo.usuario}</td>
          <td>${emprestimo.livro}</td>
          <td>${emprestimo.dataEmprestimo}</td>
          <td>${emprestimo.dataDevolucao}</td>
          <td>${emprestimo.status}</td>
          <td>
            <button class="btn btn-success btn-sm">Devolver</button>
            <button class="btn btn-danger btn-sm">Cancelar</button>
          </td>
        </tr>
      `;
      emprestimosTableBody.innerHTML += row;
    });
  });
  document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault();
  
    const formData = new FormData(this);
  
    fetch('login.php', {
      method: 'POST',
      body: formData,
    })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          window.location.href = data.redirect;
        } else {
          alert(data.message);
        }
      })
      .catch(error => console.error('Erro:', error));
  });
  
  