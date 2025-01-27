<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbdt";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Processar o envio do formulário para adicionar empréstimo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_emprestimo'])) {
    $usuario_id = mysqli_real_escape_string($conn, $_POST['usuario_id']);
    $livro_id = mysqli_real_escape_string($conn, $_POST['livro_id']);
    $data_emprestimo = mysqli_real_escape_string($conn, $_POST['data_emprestimo']);
    $data_devolucao = mysqli_real_escape_string($conn, $_POST['data_devolucao']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Query para inserir o empréstimo
    $sql = "INSERT INTO emprestimos (usuario_id, livro_id, data_emprestimo, data_devolucao, status) 
            VALUES ('$usuario_id', '$livro_id', '$data_emprestimo', '$data_devolucao', '$status')";

    if ($conn->query($sql) !== TRUE) {
        echo "<div class='alert alert-danger'>Erro: " . $conn->error . "</div>";
    }
}

// Processar a exclusão do empréstimo
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $sql_delete = "DELETE FROM emprestimos WHERE id = $delete_id";
    if ($conn->query($sql_delete) !== TRUE) {
        echo "<div class='alert alert-danger'>Erro ao excluir empréstimo: " . $conn->error . "</div>";
    }
}

// Query para recuperar todos os empréstimos
$sql_select = "SELECT * FROM emprestimos";
$result = $conn->query($sql_select);

// Query para recuperar os usuários
$sql_usuarios = "SELECT id, nome FROM usuarios";
$usuarios_result = $conn->query($sql_usuarios);

// Query para recuperar os livros
$sql_livros = "SELECT id, titulo FROM livros";
$livros_result = $conn->query($sql_livros);

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
    background-color: #1565c0;
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

  /* Responsividade */
  @media (max-width: 768px) {
    .sidebar {
      width: 200px;
    }

    .sidebar.toggled {
      transform: translateX(-200px);
    }

    .content {
      margin-left: 210px;
    }

    .content.toggled {
      margin-left: 0;
    }
  }

  @media (max-width: 576px) {
    .sidebar {
      width: 100%;
      height: auto;
      position: relative;
    }

    .sidebar.toggled {
      transform: translateY(-100%);
    }

    .content {
      margin-left: 0;
      padding: 10px;
    }
  }
</style>

</head>

<body>
  <!-- Barra lateral -->
  <div class="sidebar">
    <h4 class="text-center">Biblioteca</h4>
    <a href="adm_index.php"><i class="bi bi-speedometer2"></i>Painel</a>
    <a href="adm_livros.php"><i class="bi bi-book"></i>Livros</a>
    <a href="adm_usuarios.php"><i class="bi bi-people"></i>Usuários</a>
    <a href="adm_emprestimos.php"><i class="bi bi-box-arrow-up"></i>Empréstimos</a>
    <a href="adm_funcionario.php"><i class="bi bi-person-badge"></i>Funcionário</a>
  </div>

  <!-- Conteúdo principal -->
  <div class="content">
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
      <div class="container-fluid">
        <button class="btn btn-primary d-lg-none" id="menu-toggle"><i class="bi bi-list"></i></button>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle" style="font-size: 1.5rem; margin-right: 8px;"></i>
                <span> Adm</span>
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

    <div class="container mt-5">
      <h2>Gerenciamento de Empréstimos</h2>
      <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addEmprestimoModal">Novo empréstimo</button>

      <table class="table table-bordered">
        <thead class="table-dark">
          <tr>
            <th>Usuário</th>
            <th>Livro</th>
            <th>Data de Empréstimo</th>
            <th>Data de Devolução</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $row['usuario_id'] . "</td>"; // Nome do usuário (ID referenciado)
                  echo "<td>" . $row['livro_id'] . "</td>";   // Título do livro (ID referenciado)
                  echo "<td>" . $row['data_emprestimo'] . "</td>";
                  echo "<td>" . $row['data_devolucao'] . "</td>";
                  echo "<td>" . $row['status'] . "</td>";
                  echo "<td>
                          <a href='?delete_id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Excluir</a>
                        </td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='6'>Nenhum empréstimo encontrado.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>

    <!-- Modal para Adicionar Empréstimo -->
    <div class="modal fade" id="addEmprestimoModal" tabindex="-1" aria-labelledby="addEmprestimoModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addEmprestimoModalLabel">Adicionar Empréstimo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body">
            <form action="adm_emprestimos.php" method="post">
              <div class="mb-3">
                <label for="usuario_id" class="form-label">Usuário</label>
                <select class="form-select" id="usuario_id" name="usuario_id" required>
                  <option value="">Selecione um usuário</option>
                  <?php
                  if ($usuarios_result->num_rows > 0) {
                      while ($usuario = $usuarios_result->fetch_assoc()) {
                          echo "<option value='" . $usuario['id'] . "'>" . $usuario['nome'] . "</option>";
                      }
                  }
                  ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="livro_id" class="form-label">Livro</label>
                <select class="form-select" id="livro_id" name="livro_id" required>
                  <option value="">Selecione um livro</option>
                  <?php
                  if ($livros_result->num_rows > 0) {
                      while ($livro = $livros_result->fetch_assoc()) {
                          echo "<option value='" . $livro['id'] . "'>" . $livro['titulo'] . "</option>";
                      }
                  }
                  ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="data_emprestimo" class="form-label">Data de Empréstimo</label>
                <input type="date" class="form-control" id="data_emprestimo" name="data_emprestimo" required>
              </div>
              <div class="mb-3">
                <label for="data_devolucao" class="form-label">Data de Devolução</label>
                <input type="date" class="form-control" id="data_devolucao" name="data_devolucao">
              </div>
              <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                  <option value="ativo">Ativo</option>
                  <option value="finalizado">Finalizado</option>
                </select>
              </div>
              <button type="submit" name="add_emprestimo" class="btn btn-primary">Adicionar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
