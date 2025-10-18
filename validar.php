<?php
session_start();
require_once 'conexao.php';

// Recebe os dados do formulário
$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

if (empty($email) || empty($senha)) {
    echo "<script>alert('Por favor, preencha todos os campos.'); window.history.back();</script>";
    exit;
}

// Busca o funcionário pelo e-mail
$sql = "SELECT * FROM funcionarios WHERE email = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Verifica se encontrou o usuário
if ($funcionario = mysqli_fetch_assoc($result)) {
    // Verifica a senha usando password_verify
    if (password_verify($senha, $funcionario['senha'])) {
        // Cria sessão
        $_SESSION['funcionario_id'] = $funcionario['id'];
        $_SESSION['funcionario_nome'] = $funcionario['nome'];
        header("Location: funcionarios.php"); // Redireciona para área restrita
        exit;
    } else {
        echo "<script>alert('Senha incorreta.'); window.history.back();</script>";
        exit;
    }
} else {
    echo "<script>alert('Usuário não encontrado.'); window.history.back();</script>";
    exit;
}

// Fecha a conexão
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
