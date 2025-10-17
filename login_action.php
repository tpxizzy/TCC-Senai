<?php
session_start();
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $senha = trim($_POST['senha']);

    // Verifica se é email ou CPF
    if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
        $sql = "SELECT * FROM clientes WHERE email = ? LIMIT 1";
    } else {
        $sql = "SELECT * FROM clientes WHERE cpf = ? LIMIT 1";
    }

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $result = $stmt->get_result();
        $cliente = $result->fetch_assoc();

        if ($cliente && password_verify($senha, $cliente['senha_hash'])) {
            // Salvar dados do cliente na sessão
            $_SESSION['cliente_id']       = $cliente['id'];
            $_SESSION['cliente_nome']     = $cliente['nome_completo'];
            $_SESSION['cliente_email']    = $cliente['email'];
            $_SESSION['cliente_cpf']      = $cliente['cpf'];
            $_SESSION['cliente_telefone'] = $cliente['telefone'];

            header("Location: agendamento.php");
            exit;
        } else {
            $_SESSION['login_err'] = "Login ou senha inválidos!";
            header("Location: login_cliente.php");
            exit;
        }

        $stmt->close();
    } else {
        $_SESSION['login_err'] = "Erro ao preparar a consulta.";
        header("Location: login_cliente.php");
        exit;
    }
} else {
    header("Location: login_cliente.php");
    exit;
}
?>
