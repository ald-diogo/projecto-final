<?php
$servername = "localhost"; // ou o endereço do seu servidor de banco de dados
$username = "root"; // seu usuário do MySQL
$password = ""; // sua senha do MySQL
$dbname = "dbdt"; // nome do banco de dados

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
  die("Conexão falhou: " . $conn->connect_error);
}
 

 
// Conectar ao banco de dados
 // inclui o arquivo de conexão, se necessário

// Obter o total de livros
$query_livros = "SELECT COUNT(*) AS total_livros FROM livros";
$result_livros = $conn->query($query_livros);
$row_livros = $result_livros->fetch_assoc();
$total_livros = $row_livros['total_livros'];

// Obter o total de usuários
$query_usuarios = "SELECT COUNT(*) AS total_usuarios FROM usuarios";
$result_usuarios = $conn->query($query_usuarios);
$row_usuarios = $result_usuarios->fetch_assoc();
$total_usuarios = $row_usuarios['total_usuarios'];

// Obter o total de empréstimos ativos
$query_emprestimos = "SELECT COUNT(*) AS emprestimos_ativos FROM emprestimos WHERE status = 'ativo'";
$result_emprestimos = $conn->query($query_emprestimos);
$row_emprestimos = $result_emprestimos->fetch_assoc();
$emprestimos_ativos = $row_emprestimos['emprestimos_ativos'];


// Fechar a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de Biblioteca</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    /* Estilização personalizada */
    body {
      background-color: #f8f9fa;
    }

    .sidebar {
      height: 100vh;
      background-color: #1565c0; /* Azul meditação */
      color: #fff;
      padding-top: 20px;
      position: fixed;
      width: 250px;
      transition: transform 0.3s ease;
    }

    .sidebar.toggled {
      transform: translateX(-250px);
    }

    .sidebar a {
      color: #ddd;
      text-decoration: none;
      display: flex;
      align-items: center;
      padding: 10px 15px;
      transition: background-color 0.3s, color 0.3s;
    }

    .sidebar a i {
      margin-right: 10px;
    }

    .sidebar a:hover {
      background-color: #495057;
      color: #fff;
    }

    .content {
      margin-left: 260px;
      padding: 20px;
      transition: margin-left 0.3s ease;
    }

    .content.toggled {
      margin-left: 0;
    }

    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }

    .navbar {
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Estilização dos cartões com as cores específicas */
    .card-azul {
      background-color: #1565c0; /* Azul */
      color: #fff;
    }

    .card-vermelho {
      background-color: #d32f2f; /* Vermelho */
      color: #fff;
    }

    .card-laranja {
      background-color:rgb(117, 44, 10); /* Laranja */
      color: #fff;
    }

    .card-verde {
      background-color: #388e3c; /* Verde */
      color: #fff;
    }
  </style>
</head>
<body>
  <!-- Barra lateral -->
  <div class="sidebar">
    <h4 class="text-center">Biblioteca</h4>
    <a href="index.php"><i class="bi bi-speedometer2"></i>Painel</a>
    <a href="livros.php"><i class="bi bi-book"></i>Livros</a>
    <a href="usuarios.php"><i class="bi bi-people"></i>Usuários</a>
    <a href="emprestimos.php"><i class="bi bi-box-arrow-up"></i>Empréstimos</a>
  </div>

  <!-- Conteúdo principal -->
  <div id="page-content-wrapper" class="content">
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
      <div class="container-fluid">
        <button class="btn btn-primary d-lg-none" id="menu-toggle">
          <i class="bi bi-list"></i>
        </button>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle" style="font-size: 1.5rem; margin-right: 8px;"></i>
                <span> Funcionário</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="#">Configurações</a></li>
                <li><a class="dropdown-item" href="#">Perfil</a></li>
                <li><div class="dropdown-divider"></div></li>
                <li><a class="dropdown-item" href="adm_inicio.php">Sair</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container mt-4">
      <!-- Cartões superiores -->
      <div class="row">
        <div class="col-md-3">
          <div class="card p-3 mb-4 card-azul">
            <h6>Total de Livros</h6>
            <h3><?php echo $total_livros; ?></h3>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card p-3 mb-4 card-vermelho">
            <h6>Usuários Registrados</h6>
            <h3><?php echo $total_usuarios; ?></h3>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card p-3 mb-4 card-laranja">
            <h6>Empréstimos Ativos</h6>
            <h3><?php echo $emprestimos_ativos; ?></h3>


          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const menuToggle = document.getElementById('menu-toggle');
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('page-content-wrapper');

    menuToggle.addEventListener('click', () => {
      sidebar.classList.toggle('toggled');
      content.classList.toggle('toggled');
    });
  </script>
</body>
</html>
