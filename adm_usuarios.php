<?php
// Iniciar a sessão, se necessário
session_start();

// Conexão com o banco de dados MySQL
$servername = "localhost";  // ou o IP do seu servidor MySQL
$username = "root";         // seu usuário do banco de dados
$password = "";             // sua senha do banco de dados
$dbname = "dbdt";           // nome do seu banco de dados

// Criar a conexão com MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Processar o envio do formulário para adicionar usuário
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_usuario'])) {
    // Captura os dados do formulário e escapa para evitar SQL Injection
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $telefone = mysqli_real_escape_string($conn, $_POST['telefone']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $data_cadastro = mysqli_real_escape_string($conn, $_POST['data-cadastro']);

    // Query para inserir dados na tabela
    $sql = "INSERT INTO usuarios (nome, email, telefone, status, data_cadastro) 
            VALUES ('$nome', '$email', '$telefone', '$status', '$data_cadastro')";

    if ($conn->query($sql) !== TRUE) {
        echo "<div class='alert alert-danger'>Erro: " . $conn->error . "</div>";
    }
}

// Processar a exclusão do usuário
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $sql_delete = "DELETE FROM usuarios WHERE id = $delete_id";
    if ($conn->query($sql_delete) !== TRUE) {
        echo "<div class='alert alert-danger'>Erro ao excluir usuário: " . $conn->error . "</div>";
    }
}

// Processar a atualização do usuário
if (isset($_POST['edit_usuario'])) {
    $id = $_POST['id'];
    $nome = mysqli_real_escape_string($conn, $_POST['nome']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $telefone = mysqli_real_escape_string($conn, $_POST['telefone']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $data_cadastro = mysqli_real_escape_string($conn, $_POST['data-cadastro']);

    $sql_edit = "UPDATE usuarios SET nome='$nome', email='$email', telefone='$telefone', 
                status='$status', data_cadastro='$data_cadastro' WHERE id = $id";

    if ($conn->query($sql_edit) !== TRUE) {
        echo "<div class='alert alert-danger'>Erro ao atualizar usuário: " . $conn->error . "</div>";
    }
}

// Query para recuperar todos os usuários
$sql_select = "SELECT * FROM usuarios";
$result = $conn->query($sql_select);

// Fechar a conexão após o processamento
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
    }

    .navbar {
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
      <h2>Gerenciamento de Usuários</h2>
      <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUsuarioModal">Adicionar Usuário</button>
      <table class="table table-bordered">
        <thead class="table-dark">
          <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody id="usuarios-table-body">
          <?php
          // Exibir os usuários na tabela
          if ($result->num_rows > 0) {
              // Exibe cada linha de dados
              while($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['telefone']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                  echo "<td>
                          <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editUsuarioModal'
                                  data-id='" . $row['id'] . "' 
                                  data-nome='" . $row['nome'] . "' 
                                  data-email='" . $row['email'] . "' 
                                  data-telefone='" . $row['telefone'] . "' 
                                  data-status='" . $row['status'] . "'>
                            Editar
                          </button>
                          <a href='?delete_id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Excluir</a>
                        </td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='5'>Nenhum usuário encontrado.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>

    <!-- Modal para Adicionar Usuário -->
    <div class="modal fade" id="addUsuarioModal" tabindex="-1" aria-labelledby="addUsuarioModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addUsuarioModalLabel">Adicionar Usuário</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body">
            <form action="adm_usuarios.php" method="post">
              <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <div class="mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" required>
              </div>
              <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status" required>
                  <option value="Ativo">Ativo</option>
                  <option value="Inativo">Inativo</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="data-cadastro" class="form-label">Data de Cadastro</label>
                <input type="date" class="form-control" id="data-cadastro" name="data-cadastro" required>
              </div>
              <button type="submit" name="add_usuario" class="btn btn-primary">Adicionar</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal para Editar Usuário -->
    <div class="modal fade" id="editUsuarioModal" tabindex="-1" aria-labelledby="editUsuarioModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editUsuarioModalLabel">Editar Usuário</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body">
            <form action="adm_usuarios.php" method="post">
              <input type="hidden" id="id" name="id">
              <div class="mb-3">
                <label for="edit-nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="edit-nome" name="nome" required>
              </div>
              <div class="mb-3">
                <label for="edit-email" class="form-label">Email</label>
                <input type="email" class="form-control" id="edit-email" name="email" required>
              </div>
              <div class="mb-3">
                <label for="edit-telefone" class="form-label">Telefone</label>
                <input type="text" class="form-control" id="edit-telefone" name="telefone" required>
              </div>
              <div class="mb-3">
                <label for="edit-status" class="form-label">Status</label>
                <select class="form-control" id="edit-status" name="status" required>
                  <option value="Ativo">Ativo</option>
                  <option value="Inativo">Inativo</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="edit-data-cadastro" class="form-label">Data de Cadastro</label>
                <input type="date" class="form-control" id="edit-data-cadastro" name="data-cadastro" required>
              </div>
              <button type="submit" name="edit_usuario" class="btn btn-primary">Salvar alterações</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Preencher o formulário de edição com os dados do usuário
    document.addEventListener('DOMContentLoaded', function() {
      var editUsuarioModal = document.getElementById('editUsuarioModal');
      editUsuarioModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var nome = button.getAttribute('data-nome');
        var email = button.getAttribute('data-email');
        var telefone = button.getAttribute('data-telefone');
        var status = button.getAttribute('data-status');
        
        document.getElementById('id').value = id;
        document.getElementById('edit-nome').value = nome;
        document.getElementById('edit-email').value = email;
        document.getElementById('edit-telefone').value = telefone;
        document.getElementById('edit-status').value = status;
      });
    });
  </script>
</body>
</html>
