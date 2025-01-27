document.addEventListener("DOMContentLoaded", function () {
    // Gerenciar o formulário de adicionar usuário
    const formAdicionarUsuario = document.getElementById("adicionar-usuario-form");
  
    if (formAdicionarUsuario) {
      formAdicionarUsuario.addEventListener("submit", function (event) {
        event.preventDefault(); // Impede o envio padrão do formulário
  
        // Capturando os valores do formulário
        const nome = document.getElementById("nome").value;
        const email = document.getElementById("email").value;
        const telefone = document.getElementById("telefone").value;
        const dataCadastro = document.getElementById("data-cadastro").value;
  
        // Simulação de salvamento (substitua por lógica para salvar no banco de dados)
        console.log("Novo Usuário Adicionado:");
        console.log({ nome, email, telefone, dataCadastro });
  
        // Exibe mensagem de sucesso e redireciona
        alert("Usuário adicionado com sucesso!");
        window.location.href = "usuarios.html"; // Redireciona para a página de usuários
      });
    }
  });