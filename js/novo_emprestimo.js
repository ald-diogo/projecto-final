document.addEventListener("DOMContentLoaded", function () {
    // Gerenciar o formulário de adicionar empréstimo
    const formAdicionarEmprestimo = document.getElementById("adicionar-emprestimo-form");
  
    if (formAdicionarEmprestimo) {
      formAdicionarEmprestimo.addEventListener("submit", function (event) {
        event.preventDefault(); // Impede o envio padrão do formulário
  
        // Capturando os valores do formulário
        const usuario = document.getElementById("usuario").value;
        const livro = document.getElementById("livro").value;
        const dataEmprestimo = document.getElementById("data-emprestimo").value;
        const dataDevolucao = document.getElementById("data-devolucao").value;
  
        // Simulação de salvamento (substitua por lógica para salvar no banco de dados)
        console.log("Novo Empréstimo Adicionado:");
        console.log({ usuario, livro, dataEmprestimo, dataDevolucao });
  
        // Exibe mensagem de sucesso e redireciona
        alert("Empréstimo adicionado com sucesso!");
        window.location.href = "emprestimos.html"; // Redireciona para a página de empréstimos
      });
    }
  });
  