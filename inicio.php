<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de Biblioteca</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* Estilização personalizada */
    body {
      background: url(' ') no-repeat center center fixed;
      background-size: cover;
      color: #000000;
    }

    .navbar {
      background-color: #1565c0; /* Azul meditação */
    }

    .content {
      height: calc(100vh - 56px); /* Altura total menos a altura da navbar */
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
    }

    .content h2 {
      font-size: 2.5rem;
      text-shadow: 1px 1px 4px rgb(0, 0, 0);
      color: hsl(0, 0%, 0%); /* Texto na cor preta */
    }

    .content img {
      max-width: 150px; /* Ajuste o tamanho da imagem */
      margin-bottom: 20px; /* Espaçamento abaixo da imagem */
      animation: moveImage 5s infinite alternate; /* Animação de movimento */
    }

    /* Definindo a animação */
    @keyframes moveImage {
      0% {
        transform: translateY(0); /* Posição inicial */
      }
      50% {
        transform: translateY(-20px); /* Subir um pouco */
      }
      100% {
        transform: translateY(0); /* Voltar à posição inicial */
      }
    }

    .content .btn {
      margin-top: 20px;
      background-color: h#007f8e(194 8% 35%); /*botao SUL MEDITACAO
      border: none;
      box-shadow: 0 4px 6px #1565c0(0, 0, 0, 0.1);
    }

    .modal-content {
      background-color: #1565c0; /* Azul meditação */
    }

    .modal-body .form-control {
      background-color: #ffffff; /* Azul meditação claro para os campos do formulário */
      border: none;
      color: #000000 ;
    }

    .modal-body .form-control:focus {
      background-color: #3392ff; /* Azul meditação mais escuro ao focar no campo */
    }

    .modal-header .btn-close {
      color: #fff; /* Fechar modal com cor branca */
    }

  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1565c0;">
    <div class="container-fluid">
      <span class="navbar-brand">Sistema de Biblioteca</span>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Fazer Login</button>
    </div>
  </nav>

  <!-- Conteúdo principal -->
  <div class="content">
    <!-- Imagem do livro -->
    <img src="img/pngwing.com.png" alt="Imagem de um livro">
    <h2>Bem-vindo ao Sistema Bibliotecário</h2>
    <p>Faça o seu login para acessar o sistema.</p>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Fazer Login</button>
  </div>

  <!-- Modal de Login -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="loginModalLabel">Login</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label for="nome" class="form-label">Nome</label>
              <div class="input-group">
                <span class="input-group-text">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM2 13s-1 0-1-1 1-4 7-4 7 3 7 4-1 1-1 1H2zm14 0c0-1-1-4-7-4-6 0-7 3-7 4 0 1 1 1 1 1h12c0 0 1 0 1-1z"/>
                  </svg>
                </span>
                <input type="text" class="form-control" id="nome" placeholder="Digite seu nome">
              </div>
            </div>
            <div class="mb-3">
              <label for="senha" class="form-label">Senha</label>
              <div class="input-group">
                <span class="input-group-text">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
                    <path d="M3.5 0a3.5 3.5 0 1 0 2.45 5.954l-1.016 1.017a.5.5 0 0 0 .707.707l1.016-1.017A3.5 3.5 0 0 0 3.5 0zm1 4a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                    <path d="M9.5 2a3.5 3.5 0 0 0-3.415 4.393l-.97.97A.5.5 0 0 0 5.5 8.5h4.293l3.353 3.354a.5.5 0 0 0 .708-.708L10.5 8H9a.5.5 0 0 1-.5-.5v-2A1.5 1.5 0 0 1 10 4h2A1.5 1.5 0 0 1 13.5 5.5V6a.5.5 0 0 1-1 0v-.5a.5.5 0 0 0-.5-.5h-2a.5.5 0 0 0-.5.5v2A1.5 1.5 0 0 1 9.5 9H5.707l-.646.646A1.5 1.5 0 0 0 9.5 13h4a1.5 1.5 0 0 0 1.414-2.016l1.657-1.657A1.5 1.5 0 0 0 14.5 6h-5z"/>
                  </svg>
                </span>
                <input type="password" class="form-control" id="senha" placeholder="Digite sua senha">
              </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>