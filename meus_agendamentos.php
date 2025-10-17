<?php
// meus_agendamentos.php
session_start();
require_once 'conexao.php';

// Verifica se está logado
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login_meus_agendamentos.php");
    exit;
}

$cliente_id = $_SESSION['cliente_id'];

// Buscar agendamentos do cliente
$sql = "SELECT nome_pet, tipo_servico, data_agendamento, horario_agendamento, metodo_pagamento, valor_total, status 
        FROM agendamentos 
        WHERE cliente_id = ? 
        ORDER BY data_agendamento DESC, horario_agendamento DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cliente_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <title>Meus Agendamentos - Miau e AuAu</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
  <style>
    body { background:#f7f9fc; }
    .container { margin-top:50px; }
    .card { border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.08); }
    th { background:#007bff; color:#fff; }
  </style>
</head>
<body>
  <div class="container">
    <div class="card p-4">
      <h3 class="text-center mb-4">📋 Meus Agendamentos</h3>
      <p><strong>Cliente:</strong> <?= htmlspecialchars($_SESSION['cliente_nome']) ?></p>

      <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Pet</th>
                <th>Serviços</th>
                <th>Data</th>
                <th>Horário</th>
                <th>Pagamento</th>
                <th>Valor Total</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                  <td><?= htmlspecialchars($row['nome_pet']) ?></td>
                  <td><?= htmlspecialchars($row['tipo_servico']) ?></td>
                  <td><?= date("d/m/Y", strtotime($row['data_agendamento'])) ?></td>
                  <td><?= date("H:i", strtotime($row['horario_agendamento'])) ?></td>
                  <td><?= htmlspecialchars($row['metodo_pagamento']) ?></td>
                  <td>R$ <?= number_format($row['valor_total'], 2, ',', '.') ?></td>
                  <td>
                    <?php if ($row['status'] === "Pendente"): ?>
                      <span class="badge badge-warning">Pendente</span>
                    <?php elseif ($row['status'] === "Concluído"): ?>
                      <span class="badge badge-success">Concluído</span>
                    <?php else: ?>
                      <span class="badge badge-secondary"><?= htmlspecialchars($row['status']) ?></span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <div class="alert alert-info">Você ainda não possui agendamentos.</div>
      <?php endif; ?>

      <div class="text-center mt-3">
        <a href="agendamento.php" class="btn btn-primary">➕ Novo Agendamento</a>
        <a href="logout.php" class="btn btn-danger">Sair</a>
      </div>
    </div>
  </div>
</body>
</html>
