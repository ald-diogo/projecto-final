document.addEventListener('DOMContentLoaded', function() {
  // Captura o formulário de adicionar funcionário
  const form = document.getElementById('add-funcionario-form');

  form.addEventListener('submit', function(event) {
    event.preventDefault();  // Previne o envio padrão do formulário

    // Captura os dados do formulário
    const nome = document.getElementById('nome').value;
    const login = document.getElementById('login').value;
    const senha = document.getElementById('senha').value;
    const dataNascimento = document.getElementById('dataNascimento').value;
    const telefone = document.getElementById('telefone').value;
    const morada = document.getElementById('morada').value;
    const identidade = document.getElementById('identidade').value;

    // Cria um objeto FormData
    const formData = new FormData();
    formData.append('nome', nome);
    formData.append('login', login);
    formData.append('senha', senha);
    formData.append('dataNascimento', dataNascimento);
    formData.append('telefone', telefone);
    formData.append('morada', morada);
    formData.append('identidade', identidade);

    // Envia os dados via AJAX para o backend (arquivo PHP)
    fetch('funcionario_save.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.text())
    .then(data => {
      // Exibe a resposta do servidor (sucesso ou erro)
      alert(data);
      // Se o cadastro for bem-sucedido, você pode limpar o formulário
      form.reset();
      // Fechar o modal
      const modal = new bootstrap.Modal(document.getElementById('addFuncionarioModal'));
      modal.hide();
    })
    .catch(error => {
      console.error('Erro:', error);
      alert('Ocorreu um erro ao salvar os dados.');
    });
  });
});
