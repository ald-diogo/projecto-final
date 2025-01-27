document.addEventListener("DOMContentLoaded", function () {
    // Gerenciar o formulário de adicionar funcionário
    const formAdicionarFuncionario = document.getElementById("adicionar-funcionario-form");
  
    if (formAdicionarFuncionario) {
      formAdicionarFuncionario.addEventListener("submit", function (event) {
        event.preventDefault(); // Impede o envio padrão do formulário
  
        // Capturando os valores do formulário
        const nome = document.getElementById("nome").value;
        const email = document.getElementById("email").value;
        const telefone = document.getElementById("telefone").value;
        const cargo = document.getElementById("cargo").value;
  
        // Simulação de salvamento (substitua por lógica para salvar no banco de dados)
        console.log("Novo Funcionário Adicionado:");
        console.log({ nome, email, telefone, cargo });
  
        // Exibe mensagem de sucesso e redireciona
        alert("Funcionário adicionado com sucesso!");
        window.location.href = "funcionarios.html"; // Redireciona para a página de funcionários
      });
    }
  });