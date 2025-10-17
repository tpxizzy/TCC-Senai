<?php
session_start();
require_once 'conexao.php';

if (!isset($_SESSION['funcionario_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Não autorizado']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $concluir_id = intval($_POST['id'] ?? 0);
    if ($concluir_id > 0) {
        $update_sql = "UPDATE agendamentos SET status = 'Concluído' WHERE id = ?";
        $stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($stmt, "i", $concluir_id);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true]);
            exit;
        }
    }
}

http_response_code(400);
echo json_encode(['error' => 'Erro ao concluir agendamento']);
exit;
?>
