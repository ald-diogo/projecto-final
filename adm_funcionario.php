<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'dbdt');

// Verifica conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Inserir dados no banco
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['addFuncionario'])) {
        $nome = $_POST['nome'];
        $email = $_POST['email'];  // Alterado de 'login' para 'email'
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Hash para a senha
        $dataNascimento = $_POST['dataNascimento'];
        $telefone = $_POST['telefone'];
        $morada = $_POST['morada'];
        $identidade = $_POST['identidade'];

        $sql = "INSERT INTO funcionarios (nome, email, senha, data_nascimento, telefone, morada, identidade)
                VALUES ('$nome', '$email', '$senha', '$dataNascimento', '$telefone', '$morada', '$identidade')"; // Alterado de 'login' para 'email'

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Funcionário cadastrado com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar funcionário: " . $conn->error . "');</script>";
        }
    } elseif (isset($_POST['editFuncionario'])) {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];  // Alterado de 'login' para 'email'
        $dataNascimento = $_POST['dataNascimento'];
        $telefone = $_POST['telefone'];
        $morada = $_POST['morada'];
        $identidade = $_POST['identidade'];

        $sql = "UPDATE funcionarios SET nome='$nome', email='$email', data_nascimento='$dataNascimento', telefone='$telefone', morada='$morada', identidade='$identidade' WHERE id=$id"; // Alterado de 'login' para 'email'

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Funcionário atualizado com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao atualizar funcionário: " . $conn->error . "');</script>";
        }
    } elseif (isset($_POST['deleteFuncionario'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM funcionarios WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Funcionário excluído com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao excluir funcionário: " . $conn->error . "');</script>";
        }
    }
}

// Buscar dados do banco para exibir na tabela
$sql = "SELECT * FROM funcionarios";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema de Biblioteca</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
  <h2>Gerenciamento de Funcionários</h2>
  <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addFuncionarioModal">Adicionar Funcionário</button>
  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>Nome</th>
        <th>Email</th> <!-- Alterado de 'login' para 'email' -->
        <th>Data de Nascimento</th>
        <th>Telefone</th>
        <th>Morada</th>
        <th>Identidade</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['nome']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td> <!-- Alterado de 'login' para 'email' -->
            <td><?= htmlspecialchars($row['data_nascimento']) ?></td>
            <td><?= htmlspecialchars($row['telefone']) ?></td>
            <td><?= htmlspecialchars($row['morada']) ?></td>
            <td><?= htmlspecialchars($row['identidade']) ?></td>
            <td>
              <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editFuncionarioModal" onclick='fillEditModal(<?= json_encode($row) ?>)'>Editar</button>
              <form method="POST" action="" style="display:inline;">
                <input type="hidden" name="deleteFuncionario" value="1">
                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="7" class="text-center">Nenhum funcionário cadastrado.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- Modal para Adicionar Funcionário -->
<div class="modal fade" id="addFuncionarioModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Adicionar Funcionário</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="">
          <input type="hidden" name="addFuncionario" value="1">
          <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label> <!-- Alterado de 'login' para 'email' -->
            <input type="text" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" name="senha" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="dataNascimento" class="form-label">Data de Nascimento</label>
            <input type="date" name="dataNascimento" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="text" name="telefone" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="morada" class="form-label">Morada</label>
            <input type="text" name="morada" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="identidade" class="form-label">Identidade</label>
            <input type="text" name="identidade" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal para Editar Funcionário -->
<div class="modal fade" id="editFuncionarioModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="">
        <div class="modal-header">
          <h5 class="modal-title">Editar Funcionário</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="editFuncionario" value="1">
          <input type="hidden" name="id" id="editId">
          <div class="mb-3">
            <label for="editNome" class="form-label">Nome</label>
            <input type="text" name="nome" id="editNome" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="editEmail" class="form-label">Email</label> <!-- Alterado de 'login' para 'email' -->
            <input type="text" name="email" id="editEmail" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="editDataNascimento" class="form-label">Data de Nascimento</label>
            <input type="date" name="dataNascimento" id="editDataNascimento" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="editTelefone" class="form-label">Telefone</label>
            <input type="text" name="telefone" id="editTelefone" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="editMorada" class="form-label">Morada</label>
            <input type="text" name="morada" id="editMorada" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="editIdentidade" class="form-label">Identidade</label>
            <input type="text" name="identidade" id="editIdentidade" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function fillEditModal(data) {
    document.getElementById('editId').value = data.id;
    document.getElementById('editNome').value = data.nome;
    document.getElementById('editEmail').value = data.email; // Alterado de 'login' para 'email'
    document.getElementById('editDataNascimento').value = data.data_nascimento;
    document.getElementById('editTelefone').value = data.telefone;
    document.getElementById('editMorada').value = data.morada;
    document.getElementById('editIdentidade').value = data.identidade;
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
