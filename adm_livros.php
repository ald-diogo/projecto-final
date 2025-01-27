<?php
// Iniciar a sessão
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

// Processar o envio do formulário para adicionar livro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_livro'])) {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $genero = $_POST['genero'];

    $stmt = $conn->prepare("INSERT INTO livros (titulo, autor, genero) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $titulo, $autor, $genero);
    $stmt->execute();
    $stmt->close();
}

// Processar a exclusão do livro
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM livros WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();
}

// Processar a atualização do livro
if (isset($_POST['edit_livro'])) {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $genero = $_POST['genero'];

    $stmt = $conn->prepare("UPDATE livros SET titulo = ?, autor = ?, genero = ? WHERE id = ?");
    $stmt->bind_param("sssi", $titulo, $autor, $genero, $id);
    $stmt->execute();
    $stmt->close();
}

// Query para recuperar todos os livros
$sql_select = "SELECT * FROM livros";
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

  <div class="content">
    <h2>Gerenciamento de Livros</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addLivroModal">Adicionar Livro</button>
    <table class="table table-bordered">
      <thead class="table-dark">
        <tr>
          <th>Título</th>
          <th>Autor</th>
          <th>Gênero</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody id="livros-table-body">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['titulo']) . "</td>";
                echo "<td>" . htmlspecialchars($row['autor']) . "</td>";
                echo "<td>" . htmlspecialchars($row['genero']) . "</td>";
                echo "<td>
                        <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editLivroModal'
                                data-id='" . $row['id'] . "' 
                                data-titulo='" . $row['titulo'] . "' 
                                data-autor='" . $row['autor'] . "' 
                                data-genero='" . $row['genero'] . "'>
                          Editar
                        </button>
                        <a href='?delete_id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Excluir</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Nenhum livro encontrado.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Modal para Adicionar Livro -->
  <div class="modal fade" id="addLivroModal" tabindex="-1" aria-labelledby="addLivroModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addLivroModalLabel">Adicionar Livro</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <form action="adm_livros.php" method="post">
            <div class="mb-3">
              <label for="titulo" class="form-label">Título</label>
              <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="mb-3">
              <label for="autor" class="form-label">Autor</label>
              <input type="text" class="form-control" id="autor" name="autor" required>
            </div>
            <div class="mb-3">
              <label for="genero" class="form-label">Gênero</label>
              <input type="text" class="form-control" id="genero" name="genero" required>
            </div>
            <button type="submit" class="btn btn-primary" name="add_livro">Adicionar Livro</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal para Editar Livro -->
  <div class="modal fade" id="editLivroModal" tabindex="-1" aria-labelledby="editLivroModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editLivroModalLabel">Editar Livro</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <form action="adm_livros.php" method="post">
            <input type="hidden" name="id" id="edit-id">
            <div class="mb-3">
              <label for="edit-titulo" class="form-label">Título</label>
              <input type="text" class="form-control" id="edit-titulo" name="titulo" required>
            </div>
            <div class="mb-3">
              <label for="edit-autor" class="form-label">Autor</label>
              <input type="text" class="form-control" id="edit-autor" name="autor" required>
            </div>
            <div class="mb-3">
              <label for="edit-genero" class="form-label">Gênero</label>
              <input type="text" class="form-control" id="edit-genero" name="genero" required>
            </div>
            <button type="submit" class="btn btn-primary" name="edit_livro">Atualizar Livro</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Preencher os campos do modal de edição
    var editModal = document.getElementById('editLivroModal');
    editModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      var id = button.getAttribute('data-id');
      var titulo = button.getAttribute('data-titulo');
      var autor = button.getAttribute('data-autor');
      var genero = button.getAttribute('data-genero');

      var editId = editModal.querySelector('#edit-id');
      var editTitulo = editModal.querySelector('#edit-titulo');
      var editAutor = editModal.querySelector('#edit-autor');
      var editGenero = editModal.querySelector('#edit-genero');

      editId.value = id;
      editTitulo.value = titulo;
      editAutor.value = autor;
      editGenero.value = genero;
    });
  </script>
</body>
</html>
