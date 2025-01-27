document.addEventListener("DOMContentLoaded", function () {
    // Dados de exemplo (serão substituídos por requisições ao banco de dados)
    const usuarios = [
      { nome: "João Silva", email: "joao@email.com", telefone: "9999-9999", status: "Ativo" },
      { nome: "Maria Oliveira", email: "maria@email.com", telefone: "8888-8888", status: "Inativo" },
    ];
  
    const usuariosTableBody = document.getElementById("usuarios-table-body");
    usuarios.forEach(usuario => {
      const row = `
        <tr>
          <td>${usuario.nome}</td>
          <td>${usuario.email}</td>
          <td>${usuario.telefone}</td>
          <td>${usuario.status}</td>
          <td>
            <button class="btn btn-warning btn-sm">Editar</button>
            <button class="btn btn-danger btn-sm">Excluir</button>
          </td>
        </tr>
      `;
      usuariosTableBody.innerHTML += row;
    });
  });
  