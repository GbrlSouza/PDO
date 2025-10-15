<?php
require_once 'pessoa.php';
$pessoas = new Pessoa("pdo", "localhost", "root", "");
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title>PDO YT</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>

  <body>
    <?php
    if (isset($_POST['inputNome'])) {
      if (isset($_GET['id_update']) && !empty($_GET['id_update'])) {
        $id = addcslashes(trim($_GET['id_update']),'\'');
        $nome = addslashes($_POST['inputNome']);
        $email = addslashes($_POST['inputEmail']);
        $telefone = addslashes($_POST['inputTelefone']);

        if (!empty($nome) && !empty($email) && !empty($telefone)) {
          if ($pessoas -> updatePessoa($id, $nome, $email, $telefone)) {
            header("location: index.php");
            echo "<div class='alert alert-success text-center' role='alert'>Cadastro Atualizado com sucesso!</div>";
          } else { echo "<div class='alert alert-warning text-center' role='alert'>Email já cadastrado!</div>"; }
        } else { echo "<div class='alert alert-danger text-center' role='alert'>Preencha todos os campos!</div>"; }
      } else {
        $nome = addslashes($_POST['inputNome']);
        $email = addslashes($_POST['inputEmail']);
        $telefone = addslashes($_POST['inputTelefone']);

        if (!empty($nome) && !empty($email) && !empty($telefone)) {
          if ($pessoas -> addPessoa($nome, $email, $telefone)) { echo "<div class='alert alert-success text-center' role='alert'>Pessoa cadastrada com sucesso!</div>";}
          else { echo "<div class='alert alert-warning text-center' role='alert'>Email já cadastrado!</div>"; }
        } else { echo "<div class='alert alert-danger text-center' role='alert'>Preencha todos os campos!</div>"; }
      }
    }

    if (isset($_GET['id_update'])) {
      $id_pessoa = addslashes($_GET['id_update']);
      $pessoa = $pessoas -> searchPessoa($id_pessoa);
    }

    if (isset($_GET['id_delete'])) {
      $id_pessoa = addslashes($_GET['id_delete']);
      $pessoas -> deletePessoa($id_pessoa);

      header("location: index.php");
    }
    ?>
    <div class="container">
      <div class="form-section">
        <h2 class="mb-4 text-primary">Cadastro de Pessoa</h2>

        <form method="POST">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="inputNome" class="form-label">Nome Completo</label>
              <input type="text" class="form-control" id="inputNome" name="inputNome" placeholder="Digite o nome completo" required value="<?php if (isset($pessoa)) { echo $pessoa['nome']; } ?>">
            </div>
            <div class="col-md-6">
              <label for="inputEmail" class="form-label">Email</label>
              <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="exemplo@dominio.com" required value="<?php if (isset($pessoa)) { echo $pessoa['email']; } ?>">
            </div>
            <div class="col-12">
              <label for="inputTelefone" class="form-label">Telefone</label>
              <input type="tel" class="form-control" id="inputTelefone" name="inputTelefone" placeholder="(XX) XXXXX-XXXX" required value="<?php if (isset($pessoa)) { echo $pessoa['telefone']; } ?>">
            </div>
            <div class="col-12 mt-4">
              <input type="submit" class="btn btn-success" value="<?php if (isset($pessoa)) { echo "Atualizar Cadastro"; } else { echo "Cadastrar Pessoa"; } ?>">
              <button type="reset" class="btn btn-secondary ms-2">Limpar Formulário</button>
            </div>
          </div>
        </form>
      </div>

      <div class="table-section">
        <h2 class="mb-4 text-primary">Pessoas Cadastradas</h2>

        <div class="table-responsive">
          <table class="table table-hover table-striped">
            <thead class="table-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Telefone</th>
                <th scope="col" class="text-center">Ações</th>
              </tr>
            </thead>

            <tbody>
              <?php
              $pessoa = $pessoas -> getPessoa();

              if (count($pessoa) > 0) {
                for ($i = 0; $i < count($pessoa); $i++) {
                  echo "<tr>";
                  foreach ($pessoa[$i] as $key => $value) {
                    if ($key === 'id') { echo '<th scope="row">' . $value .'</th>'; }
                    else { echo '<td>' . $value . '</td>'; }
                  }
                  ?>
                  <td class="text-center">
                    <a href="index.php?id_update=<?php echo $pessoa[$i]['id']; ?>" class="btn btn-sm btn-warning me-2">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.173.656l.896 2.434.619.619c.141.141.331.221.533.221h.166l2.585.877a.5.5 0 0 0 .656-.173l6.5-6.5z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                      </svg>

                      Editar
                    </a>
                    <a href="index.php?id_delete=<?php echo $pessoa[$i]['id']; ?>" class="btn btn-sm btn-danger">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                      </svg>

                      Excluir
                    </a>
                  </td>
                  <?php
                  echo "</tr>";
                }
              } else { echo "<tr><td colspan='5' class='text-center'>Nenhuma pessoa cadastrada!</td></tr>"; }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>
