<?php
require_once 'conexao.php';

$nome_cliente = $_POST['nome_cliente'] ?? '';
$nome_pet = $_POST['nome_pet'] ?? '';
$tipo_servico = $_POST['tipo_servico'] ?? '';
$data_agendamento = $_POST['data_agendamento'] ?? '';
$horario_agendamento = $_POST['horario_agendamento'] ?? '';
$contato_cliente = $_POST['contato_cliente'] ?? '';
$metodo_pagamento = $_POST['metodo_pagamento'] ?? '';

// Validação simples
if (!$nome_cliente || !$nome_pet || !$tipo_servico || !$data_agendamento || !$horario_agendamento || !$contato_cliente || !$metodo_pagamento) {
    die("Erro: todos os campos são obrigatórios.");
}

// Prepare o SQL com o método de pagamento
$sql = "INSERT INTO agendamentos (nome_cliente, nome_pet, tipo_servico, data_agendamento, horario_agendamento, contato_cliente, status, metodo_pagamento)
        VALUES (?, ?, ?, ?, ?, ?, 'Pendente', ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param('sssssss', $nome_cliente, $nome_pet, $tipo_servico, $data_agendamento, $horario_agendamento, $contato_cliente, $metodo_pagamento);

if ($stmt->execute()) {
    echo "Agendamento realizado com sucesso!";
} else {
    echo "Erro ao realizar agendamento.";
}
?>
