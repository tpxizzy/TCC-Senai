<?php
// register.php
session_start();
if (isset($_SESSION['cliente_id'])) {
    header('Location: agendamento.php');
    exit;
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Criar Conta - Miau e AuAu</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
  <style>
    body { background: linear-gradient(#f7f9fc,#eef3f9); }
    .card { max-width: 560px; margin: 40px auto; border-radius:12px; box-shadow:0 6px 18px rgba(0,0,0,0.08); }
  </style>
</head>
<body>
  <div class="card p-4">
    <h3 class="mb-3 text-center">Criar Conta</h3>
    <?php if (isset($_SESSION['register_err'])): ?>
      <div class="alert alert-danger"><?= $_SESSION['register_err']; unset($_SESSION['register_err']); ?></div>
    <?php endif; ?>
    <form action="register_action.php" method="POST" novalidate>
      <div class="form-group">
        <label>Nome completo</label>
        <input name="nome_completo" class="form-control" required>
      </div>
      <div class="form-group">
        <label>E-mail (Gmail)</label>
        <input type="email" name="email" class="form-control" placeholder="seu@gmail.com" required>
      </div>
      <div class="form-group">
        <label>Telefone</label>
        <input name="telefone" class="form-control" placeholder="(00) 9 0000-0000" required>
      </div>
      <div class="form-group">
        <label>CPF</label>
        <input name="cpf" class="form-control" placeholder="000.000.000-00" required>
      </div>
      <div class="form-row">
        <div class="form-group col">
          <label>Senha</label>
          <input type="password" name="senha" class="form-control" required>
        </div>
        <div class="form-group col">
          <label>Confirmar senha</label>
          <input type="password" name="senha_confirm" class="form-control" required>
        </div>
      </div>
      <button class="btn btn-primary btn-block" type="submit">Criar conta</button>
      <a href="login.php" class="btn btn-link btn-block">Já tenho conta — Entrar</a>
    </form>
  </div>
</body>
</html>
