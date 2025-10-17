<?php
session_start();
require_once 'conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['funcionario_id'])) {
    header("Location: login.php");
    exit;
}

// Preços dos serviços
$precos = [
    "Consulta" => 100,
    "Banho" => 50,
    "Tosa" => 25,
    "Vacinação" => 65
];

// =========================
// AÇÃO DE CANCELAR AGENDAMENTO
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancelar_id'])) {
    $cancelar_id = intval($_POST['cancelar_id']);
    $delete_sql = "DELETE FROM agendamentos WHERE id = ?";
    $stmt = mysqli_prepare($conn, $delete_sql);
    mysqli_stmt_bind_param($stmt, "i", $cancelar_id);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['msg'] = "Agendamento cancelado com sucesso!";
    } else {
        $_SESSION['msg'] = "Erro ao cancelar o agendamento.";
    }
    header("Location: funcionarios.php");
    exit;
}

// =========================
// AÇÃO DE EXCLUIR CLIENTE
// =========================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_cliente_id'])) {
    $cliente_id = intval($_POST['excluir_cliente_id']);
    $delete_sql = "DELETE FROM clientes WHERE id = ?";
    $stmt = mysqli_prepare($conn, $delete_sql);
    mysqli_stmt_bind_param($stmt, "i", $cliente_id);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['msg'] = "Cliente excluído com sucesso!";
    } else {
        $_SESSION['msg'] = "Erro ao excluir o cliente.";
    }
    header("Location: funcionarios.php");
    exit;
}

// =========================
// CONSULTAS
// =========================

// Agendamentos
$sql = "SELECT * FROM agendamentos ORDER BY data_agendamento, horario_agendamento";
$result_agendamentos = mysqli_query($conn, $sql);

// Clientes
$sql_clientes = "SELECT * FROM clientes ORDER BY nome_completo ASC";
$result_clientes = mysqli_query($conn, $sql_clientes);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Painel Funcionários - Miau e AuAu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" />
    <style>
        body { background-color: #e6f0ff; color: #003366; }
        .top-header { padding: 20px; background: linear-gradient(90deg, #007bff, #0056b3); height: 180px; display: flex; justify-content: center; align-items: center; margin-bottom: 30px; }
        .top-header img { max-width: 120px; border-radius: 50%; margin-bottom: 10px; padding-top: 25px; margin-top: -25px; }
        h1 { color: #004080; font-weight: 700; }
        .btn-success { background-color: #28a745; border-color: #28a745; }
        .btn-success:hover, .btn-success:focus { background-color: #218838; border-color: #1e7e34; }
        .btn-danger { background-color: #dc3545; border-color: #dc3545; }
        .btn-danger:hover, .btn-danger:focus { background-color: #c82333; border-color: #bd2130; }
        .btn-secondary { background-color: #3399ff; border-color: #3399ff; color: white; }
        .btn-secondary:hover, .btn-secondary:focus { background-color: #0073e6; border-color: #0073e6; color: white; }
        table { background-color: #cce0ff; border-collapse: collapse; }
        thead { background-color: #007bff; color: white; }
        tbody tr:nth-child(even) { background-color: #d9e6ff; }
        tbody tr:hover { background-color: #b3ccff; }
        th, td { border: 1px solid black !important; vertical-align: middle; padding: 8px; }
        .alert-info { background-color: #cce5ff; border-color: #b8daff; color: #004085; }
        .nav-tabs .nav-link.active { background-color: #3399ff; color: white; }
    </style>
</head>
<body>
<div class="top-header">
    <img src="assets/logopet.png" alt="Logo" />
</div>

<div class="container">
    <h1 class="text-center mb-4">Painel Funcionários</h1>

    <div class="d-flex justify-content-between mb-3">
        <div>
            <a href="logout.php" class="btn btn-danger">Sair</a>
            <a href="login.php" class="btn btn-secondary">Voltar para Login</a>
        </div>
        <a href="agendamento.php" class="btn btn-success">Novo Agendamento</a>
    </div>

    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-info"><?= $_SESSION['msg']; unset($_SESSION['msg']); ?></div>
    <?php endif; ?>

    <!-- NAV TABS -->
    <ul class="nav nav-tabs mb-3" id="painelTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="agendamentos-tab" data-toggle="tab" href="#agendamentos" role="tab">Agendamentos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="clientes-tab" data-toggle="tab" href="#clientes" role="tab">Clientes</a>
        </li>
    </ul>

    <div class="tab-content" id="painelTabsContent">
        <!-- TAB AGENDAMENTOS -->
        <div class="tab-pane fade show active" id="agendamentos" role="tabpanel">
            <?php if (mysqli_num_rows($result_agendamentos) > 0): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nome do Cliente</th>
                            <th>Nome do Pet</th>
                            <th>Serviços</th>
                            <th>Método de Pagamento</th>
                            <th>Valor Total (R$)</th>
                            <th>Data</th>
                            <th>Horário</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result_agendamentos)): ?>
                            <?php
                                $servicos = explode(' / ', $row['tipo_servico']);
                                $total = 0;
                                foreach ($servicos as $s) {
                                    $s = trim($s);
                                    if (isset($precos[$s])) $total += $precos[$s];
                                }
                                $metodo_pagamento = isset($row['metodo_pagamento']) && $row['metodo_pagamento'] !== '' ? $row['metodo_pagamento'] : '-';
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($row['nome_cliente']) ?></td>
                                <td><?= htmlspecialchars($row['nome_pet']) ?></td>
                                <td><ul style="padding-left:20px;margin-bottom:0;"><?php foreach ($servicos as $s): ?><li><?= htmlspecialchars($s) ?></li><?php endforeach; ?></ul></td>
                                <td><?= htmlspecialchars($metodo_pagamento) ?></td>
                                <td><?= number_format($total,2,',','.') ?></td>
                                <td><?= date('d/m/Y', strtotime($row['data_agendamento'])) ?></td>
                                <td><?= htmlspecialchars($row['horario_agendamento']) ?></td>
                                <td><?= htmlspecialchars($row['status'] ?? 'Pendente') ?></td>
                                <td>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="cancelar_id" value="<?= $row['id'] ?>" />
                                        <button type="submit" class="btn btn-danger btn-sm">Cancelar</button>
                                    </form>
                                    <?php if (($row['status'] ?? 'Pendente') !== 'Concluído'): ?>
                                        <button class="btn btn-success btn-sm btn-concluir" data-id="<?= $row['id'] ?>">Concluído</button>
                                    <?php endif; ?>
                                    <a href="editar_agendamento.php?id=<?= $row['id'] ?>" class="btn btn-secondary btn-sm">Editar</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">Nenhum agendamento encontrado.</p>
            <?php endif; ?>
        </div>

        <!-- TAB CLIENTES -->
        <div class="tab-pane fade" id="clientes" role="tabpanel">
            <?php if (mysqli_num_rows($result_clientes) > 0): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nome Completo</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($cliente = mysqli_fetch_assoc($result_clientes)): ?>
                        <tr>
                            <td><?= htmlspecialchars($cliente['nome_completo']) ?></td>
                            <td><?= htmlspecialchars($cliente['email']) ?></td>
                            <td><?= htmlspecialchars($cliente['telefone'] ?? '-') ?></td>
                            <td>
                                <a href="editar_cliente.php?id=<?= $cliente['id'] ?>" class="btn btn-success btn-sm">Editar</a>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Deseja realmente excluir este cliente?');">
                                    <input type="hidden" name="excluir_cliente_id" value="<?= $cliente['id'] ?>" />
                                    <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">Nenhum cliente cadastrado.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll('.btn-concluir').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        if (!id) return;

        fetch('concluir_funcionario.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id=' + encodeURIComponent(id)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Atendimento concluído!');
                const tr = btn.closest('tr');
                if (tr) tr.remove();
            } else {
                alert('Erro ao concluir o atendimento.');
            }
        })
        .catch(() => {
            alert('Erro ao concluir o atendimento.');
        });
    });
});
</script>
</body>
</html>
