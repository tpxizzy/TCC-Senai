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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $nome_pet = $_POST['nome_pet'] ?? '';
    $servicos = $_POST['servico'] ?? [];
    $data_agendamento = $_POST['data_agendamento'] ?? '';
    $horario_agendamento = $_POST['horario_agendamento'] ?? '';
    $metodo_pagamento = $_POST['metodo_pagamento'] ?? '';

    // Validação básica
    if (empty($nome_pet) || empty($servicos) || empty($data_agendamento) || empty($horario_agendamento) || empty($metodo_pagamento)) {
        $_SESSION['msg'] = "Por favor, preencha todos os campos obrigatórios.";
        header("Location: editar_agendamento.php?id=" . $id);
        exit;
    }

    if (count($servicos) > 3) {
        $_SESSION['msg'] = "Você só pode selecionar até 3 serviços.";
        header("Location: editar_agendamento.php?id=" . $id);
        exit;
    }

    // Transformar array de serviços em string
    $tipo_servico = implode(' / ', $servicos);

    // Calcular valor total
    $valor_total = 0;
    foreach ($servicos as $s) {
        $s = trim($s);
        if (isset($precos[$s])) $valor_total += $precos[$s];
    }

    // Atualizar no banco
    $sql = "UPDATE agendamentos 
            SET nome_pet = ?, tipo_servico = ?, data_agendamento = ?, horario_agendamento = ?, metodo_pagamento = ?, valor_total = ? 
            WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    // Corrigido: metodo_pagamento como string ("s"), valor_total como double ("d"), id como int ("i")
    mysqli_stmt_bind_param($stmt, "sssssdi", 
        $nome_pet,
        $tipo_servico,
        $data_agendamento,
        $horario_agendamento,
        $metodo_pagamento,
        $valor_total,
        $id
    );

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['msg'] = "Agendamento atualizado com sucesso!";
        header("Location: funcionarios.php");
        exit;
    } else {
        $_SESSION['msg'] = "Erro ao atualizar agendamento: " . mysqli_error($conn);
        header("Location: editar_agendamento.php?id=" . $id);
        exit;
    }

} else {
    echo "Método de requisição inválido.";
    exit;
}
?>
