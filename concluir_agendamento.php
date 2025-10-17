<?php
session_start();
if (!isset($_SESSION['funcionario_id'])) {
    header("Location: login.php");
    exit;
}
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Atualiza o status do agendamento para 'Concluído'
    $sql = "UPDATE agendamentos SET status = 'Concluído' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['msg'] = "Agendamento marcado como concluído com sucesso.";
    } else {
        $_SESSION['msg'] = "Erro ao concluir o agendamento.";
    }
    header("Location: funcionarios.php");
    exit;
}
?>
