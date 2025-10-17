<?php
session_start();

// Verifica se o cliente está logado
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login_cliente.php");
    exit;
}

// Recupera informações do cliente logado
$cliente_nome = isset($_SESSION['cliente_nome']) ? $_SESSION['cliente_nome'] : '';
$cliente_contato = isset($_SESSION['cliente_telefone']) ? $_SESSION['cliente_telefone'] : '';
?>

<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Agendamento</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">

  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Roboto', sans-serif;
    }
    .container {
      max-width: 600px;
      margin-top: 50px;
    }
    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .card-header {
      background-color: #007bff;
      color: white;
      text-align: center;
      font-size: 24px;
      padding: 20px;
    }
    .form-control {
      border-radius: 8px;
      box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
    }
    .btn-primary, .btn-info {
      border-radius: 8px;
      padding: 10px 20px;
      font-size: 16px;
    }
    .btn-success {
      background-color: #28a745;
      border: none;
    }
    .btn-success:hover {
      background-color: #218838;
    }
    .btn-group {
      display: flex;
      justify-content: space-between;
    }
    .btn-group .btn {
      width: 48%;
    }
    .btn-group .btn:first-child {
      margin-right: 4%;
    }
    #total-container {
      margin-top: 15px;
      font-weight: bold;
      font-size: 1.2rem;
      color: #007bff;
    }
    .payment-methods label {
      margin-right: 15px;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="card">
    <div class="card-header">
      Agendamento de Serviços
    </div>
    <div class="card-body">
      <form action="agendamento_script.php" method="POST" id="agendamento-form">
        
        <!-- Nome do Cliente preenchido automaticamente -->
        <div class="form-group">
          <label for="nome_cliente">Nome do Cliente</label>
          <input type="text" class="form-control" name="nome_cliente" value="<?php echo htmlspecialchars($cliente_nome); ?>" readonly>
        </div>

        <div class="form-group">
          <label for="nome_pet">Nome do Pet</label>
          <input type="text" class="form-control" name="nome_pet" required>
        </div>

        <div class="form-group">
          <label for="servico">Tipo de Serviço (selecione até 3)</label>
          <select 
            class="form-control selectpicker" 
            name="servico[]" 
            id="servico" 
            multiple 
            data-max-options="3" 
            data-live-search="true" 
            title="Selecione até 3 serviços" 
            required>
            <option value="Banho" data-preco="50">Banho – R$ 50,00</option>
            <option value="Tosa" data-preco="25">Tosa – R$ 25,00</option>
            <option value="Vacinação" data-preco="65">Vacinação – R$ 65,00</option>
            <option value="Consulta" data-preco="100">Consulta – R$ 100,00</option>
          </select>
        </div>

        <div id="total-container">Total: R$ 0,00</div>

        <div class="form-group">
          <label for="data_agendamento">Data do Agendamento</label>
          <input type="date" class="form-control" name="data_agendamento" required>
        </div>

        <div class="form-group">
          <label for="horario_agendamento">Horário do Agendamento</label>
          <input type="time" class="form-control" name="horario_agendamento" required>
        </div>

        <!-- Contato preenchido automaticamente -->
        <div class="form-group">
          <label for="contato">Contato</label>
          <input type="text" class="form-control" name="contato" value="<?php echo htmlspecialchars($cliente_contato); ?>" readonly>
        </div>

        <div class="form-group payment-methods">
          <label><strong>Método de Pagamento:</strong></label><br>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="metodo_pagamento" id="pagamento_dinheiro" value="Dinheiro" required>
            <label class="form-check-label" for="pagamento_dinheiro">Dinheiro</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="metodo_pagamento" id="pagamento_cartao" value="Cartão">
            <label class="form-check-label" for="pagamento_cartao">Cartão de Crédito/Débito</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="metodo_pagamento" id="pagamento_pix" value="PIX">
            <label class="form-check-label" for="pagamento_pix">PIX</label>
          </div>
        </div>

        <div class="form-group text-center btn-group">
          <input type="submit" class="btn btn-success" value="Agendar">
          <a href="voltar.php" class="btn btn-info">Voltar para o início</a>
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
    let total = 0;
    const servicosSelecionados = $('#servico').val() || [];

    servicosSelecionados.forEach(servico => {
      const preco = parseFloat($(`#servico option[value='${servico}']`).data('preco')) || 0;
      total += preco;
    });

    $('#total-container').text(`Total: R$ ${total.toFixed(2).replace('.', ',')}`);
  }

  $('#servico').on('changed.bs.select', atualizarTotal);
  atualizarTotal();
});
</script>
</body>
</html>
