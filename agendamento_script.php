<?php
session_start();
require_once 'conexao.php';

// Verifica se o cliente está logado
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login_cliente.php");
    exit;
}

$cliente_id = $_SESSION['cliente_id'];
$nome_cliente = $_POST['nome_cliente'] ?? '';
$nome_pet = $_POST['nome_pet'] ?? '';
$servicos = $_POST['servico'] ?? [];
$data_agendamento = $_POST['data_agendamento'] ?? '';
$horario_agendamento = $_POST['horario_agendamento'] ?? '';
$contato = $_POST['contato'] ?? '';
$metodo_pagamento = $_POST['metodo_pagamento'] ?? 'Dinheiro';

// Valida campos obrigatórios
if (
    empty($nome_cliente) || empty($nome_pet) || 
    empty($servicos) || !is_array($servicos) || 
    empty($data_agendamento) || empty($horario_agendamento) || 
    empty($contato) || empty($metodo_pagamento)
) {
    echo "Por favor, preencha todos os campos.";
    exit;
}

if (count($servicos) > 3) {
    echo "Você só pode selecionar até 3 serviços.";
    exit;
}

// Concatena serviços selecionados
$servicos_str = implode(' / ', $servicos);

// Calcula valor total
$precos = [
    "Consulta" => 100,
    "Banho" => 50,
    "Tosa" => 25,
    "Vacinação" => 65
];

$valor_total = 0;
foreach ($servicos as $s) {
    $s = trim($s);
    if (isset($precos[$s])) {
        $valor_total += $precos[$s];
    }
}

// Prepara INSERT no banco
$sql = "INSERT INTO agendamentos 
        (cliente_id, nome_cliente, nome_pet, tipo_servico, data_agendamento, horario_agendamento, contato_cliente, metodo_pagamento, valor_total) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param(
    $stmt,
    "isssssssd", // i = cliente_id, s = string, d = decimal
    $cliente_id,
    $nome_cliente,
    $nome_pet,
    $servicos_str,
    $data_agendamento,
    $horario_agendamento,
    $contato,
    $metodo_pagamento,
    $valor_total
);

// Executa e redireciona
if (mysqli_stmt_execute($stmt)) {
    $_SESSION['msg'] = "Agendamento realizado com sucesso!";
    header("Location: meus_agendamentos.php");
    exit;
} else {
    echo "Erro ao realizar o agendamento: " . mysqli_error($conn);
}
?>
