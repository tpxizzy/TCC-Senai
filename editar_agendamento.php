<?php
session_start();
require_once 'conexao.php';

// Verifica se o funcionário está logado
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

// Obter id do agendamento
$id = $_GET['id'] ?? 0;
$id = intval($id);

// Buscar agendamento
$sql = "SELECT * FROM agendamentos WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$agendamento = mysqli_fetch_assoc($result);

if (!$agendamento) {
    echo "Agendamento não encontrado!";
    exit;
}

// Transformar serviços em array
$servicos_selecionados = explode(' / ', $agendamento['tipo_servico']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Editar Agendamento - Funcionário</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Roboto', sans-serif; }
        .container { max-width: 600px; margin-top: 50px; }
        .card { border: none; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .card-header { background-color: #007bff; color: white; text-align: center; font-size: 24px; padding: 20px; }
        .form-control { border-radius: 8px; box-shadow: inset 0 1px 2px rgba(0,0,0,0.1); }
        .btn-primary, .btn-success { border-radius: 8px; padding: 10px 20px; font-size: 16px; }
        .btn-success { background-color: #28a745; border: none; }
        .btn-success:hover { background-color: #218838; }
        #total-container { margin-top: 15px; font-weight: bold; font-size: 1.2rem; color: #007bff; }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header">
            Editar Agendamento
        </div>
        <div class="card-body">
            <form action="editar_agendamento_script.php" method="POST" id="editar-agendamento-form">
                <input type="hidden" name="id" value="<?= $agendamento['id'] ?>">

                <div class="form-group">
                    <label>Nome do Cliente</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($agendamento['nome_cliente']) ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Nome do Pet</label>
                    <input type="text" class="form-control" name="nome_pet" value="<?= htmlspecialchars($agendamento['nome_pet']) ?>" required>
                </div>

                <div class="form-group">
                    <label>Serviços (até 3)</label>
                    <select class="form-control selectpicker" name="servico[]" multiple data-max-options="3" required>
                        <?php foreach ($precos as $s => $preco): ?>
                            <option value="<?= $s ?>" <?= in_array($s, $servicos_selecionados) ? 'selected' : '' ?>>
                                <?= $s ?> (R$ <?= number_format($preco,2,',','.') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div id="total-container">Total: R$ 0,00</div>

                <div class="form-group">
                    <label>Data do Agendamento</label>
                    <input type="date" class="form-control" name="data_agendamento" value="<?= $agendamento['data_agendamento'] ?>" required>
                </div>

                <div class="form-group">
                    <label>Horário do Agendamento</label>
                    <input type="time" class="form-control" name="horario_agendamento" value="<?= $agendamento['horario_agendamento'] ?>" required>
                </div>

                <div class="form-group">
                    <label>Método de Pagamento</label>
                    <select class="form-control" name="metodo_pagamento" required>
                        <option value="Dinheiro" <?= $agendamento['metodo_pagamento'] === 'Dinheiro' ? 'selected' : '' ?>>Dinheiro</option>
                        <option value="Cartão" <?= $agendamento['metodo_pagamento'] === 'Cartão' ? 'selected' : '' ?>>Cartão</option>
                        <option value="PIX" <?= $agendamento['metodo_pagamento'] === 'PIX' ? 'selected' : '' ?>>PIX</option>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                    <a href="funcionarios.php" class="btn btn-secondary">Voltar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script>
$(document).ready(function() {
    $('.selectpicker').selectpicker();

    function atualizarTotal() {
        const precos = {
            "Consulta": 100,
            "Banho": 50,
            "Tosa": 25,
            "Vacinação": 65
        };

        let total = 0;
        const servicosSelecionados = $('select[name="servico[]"]').val() || [];
        servicosSelecionados.forEach(s => {
            total += precos[s] || 0;
        });

        $('#total-container').text(`Total: R$ ${total.toFixed(2).replace('.', ',')}`);
    }

    $('select[name="servico[]"]').on('changed.bs.select', atualizarTotal);
    atualizarTotal();
});
</script>
</body>
</html>
