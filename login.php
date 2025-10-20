<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login Funcionário - Petshop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>
<body>
    <div class="container" style="max-width: 400px; margin-top: 100px;">
        <h2 class="mb-4 text-center">Login Funcionário</h2>
        <form action="validar.php" method="post">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input 
                    type="email" 
                    class="form-control" 
                    id="email" 
                    name="email" 
                    placeholder="Digite seu e-mail" 
                    required 
                />
            </div>
            <div class="form-group">
                <label for="senha">Senha</label>
                <input 
                    type="password" 
                    class="form-control" 
                    id="senha" 
                    name="senha" 
                    placeholder="Digite sua senha" 
                    required 
                />
            </div>
            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
        </form>

        <!-- Botões abaixo do formulário -->
        <div class="d-flex justify-content-center mt-4">
            <button class="btn btn-success mr-2" data-toggle="modal" data-target="#cadastroModal">
                Cadastrar Funcionário
            </button>
            <a href="index.php" class="btn btn-secondary">Voltar para o início</a>
        </div>
    </div>

    <!-- Modal de Cadastro -->
    <div class="modal fade" id="cadastroModal" tabindex="-1" aria-labelledby="cadastroModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="register_funcionario_action.php" method="POST">
            <div class="modal-header">
              <h5 class="modal-title" id="cadastroModalLabel">Cadastrar Novo Funcionário</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              
              <div class="form-group">
                <label for="nome">Nome Completo</label>
                <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome completo" required>
              </div>

              <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Digite o e-mail" required>
              </div>

              <div class="form-group">
                <label for="senha">Criar Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" placeholder="Crie uma senha" required>
              </div>

              <div class="form-group">
                <label for="ra">RA (Número do Crachá)</label>
                <input type="text" class="form-control" id="ra" name="ra" placeholder="Digite o RA do funcionário" required>
              </div>

              <div class="form-group">
                <label for="cpf">CPF</label>
                <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Digite o CPF" required>
              </div>

              <hr>

              <div class="form-group">
                <label for="admin_user">Nome do Administrador</label>
                <input type="text" class="form-control" id="admin_user" name="admin_user" placeholder="Digite o nome do administrador" required>
              </div>

              <div class="form-group">
                <label for="senha_admin">Senha do Administrador</label>
                <input type="password" class="form-control" id="senha_admin" name="senha_admin" placeholder="Digite a senha do administrador" required>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-success">Cadastrar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Scripts Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
