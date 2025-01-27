document.addEventListener("DOMContentLoaded", function () {
    const formAdicionarLivro = document.getElementById("adicionar-livro-form");
  
    if (formAdicionarLivro) {
      formAdicionarLivro.addEventListener("submit", function (event) {
        event.preventDefault(); // Evita o envio padrão do formulário
  
        // Capturando os valores do formulário
        const titulo = document.getElementById("titulo").value;
        const autor = document.getElementById("autor").value;
        const categoria = document.getElementById("categoria").value;
        const quantidade = document.getElementById("quantidade").value;
        const ano = document.getElementById("ano").value;
  
        // Simulação de salvamento (substituir por lógica real para armazenar no banco de dados)
        console.log("Novo Livro Adicionado:");
        console.log({ titulo, autor, categoria, quantidade, ano });
  
        // Exibe mensagem de sucesso e redireciona
        alert("Livro adicionado com sucesso!");
        window.location.href = "livros.html"; // Redireciona para a página de livros
      });
    }
  });
  