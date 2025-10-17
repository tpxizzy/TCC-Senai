<?php
session_start();
if (isset($_SESSION['cliente_id'])) {
    header('Location: meus_agendamentos.php');
    exit;
}
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Entrar - Miau e AuAu</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
  <style>
    body { background: linear-gradient(#f7f9fc,#eef3f9); }
    .card { max-width:480px; margin:50px auto; border-radius:12px; box-shadow:0 6px 18px rgba(0,0,0,0.08); }
  </style>
</head>
<body>
  <div class="card p-4">
    <h3 class="mb-3 text-center">Entrar</h3>
    <?php if (isset($_SESSION['login_err'])): ?>
      <div class="alert alert-danger"><?= $_SESSION['login_err']; unset($_SESSION['login_err']); ?></div>
    <?php endif; ?>
    <form action="login_action_meus_agendamentos.php" method="POST">
      <div class="form-group">
        <label>E-mail (Gmail) ou CPF</label>
        <input name="login" class="form-control" required>
      </div>
      <div class="form-group">
        <label>Senha</label>
        <input type="password" name="senha" class="form-control" required>
      </div>
      <button class="btn btn-primary btn-block" type="submit">Entrar</button>
      <a href="register.php" class="btn btn-link btn-block">Criar conta</a>
    </form>
  </div>
</body>
</html>
