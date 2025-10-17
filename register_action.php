<?php
// register_action.php
session_start();
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: register.php');
    exit;
}

$nome = trim($_POST['nome_completo'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$cpf = trim($_POST['cpf'] ?? '');
$senha = $_POST['senha'] ?? '';
$senha_confirm = $_POST['senha_confirm'] ?? '';

// Validações
if (!$nome || !$email || !$telefone || !$cpf || !$senha || !$senha_confirm) {
    $_SESSION['register_err'] = 'Preencha todos os campos.';
    header('Location: register.php');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['register_err'] = 'E-mail inválido.';
    header('Location: register.php');
    exit;
}

if ($senha !== $senha_confirm) {
    $_SESSION['register_err'] = 'As senhas não coincidem.';
    header('Location: register.php');
    exit;
}

if (strlen($senha) < 6) {
    $_SESSION['register_err'] = 'Senha precisa ter ao menos 6 caracteres.';
    header('Location: register.php');
    exit;
}

// Verifica duplicados
$stmt = mysqli_prepare($conn, "SELECT id FROM clientes WHERE email = ? OR cpf = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "ss", $email, $cpf);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    $_SESSION['register_err'] = 'E-mail ou CPF já cadastrado.';
    mysqli_stmt_close($stmt);
    header('Location: register.php');
    exit;
}
mysqli_stmt_close($stmt);

// Inserir usuário com senha_hash
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);
$stmt = mysqli_prepare($conn, "INSERT INTO clientes (nome_completo, email, telefone, cpf, senha_hash) VALUES (?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sssss", $nome, $email, $telefone, $cpf, $senha_hash);

if (mysqli_stmt_execute($stmt)) {
    $cliente_id = mysqli_insert_id($conn);
    // Logar automaticamente após cadastro
    $_SESSION['cliente_id'] = $cliente_id;
    $_SESSION['cliente_nome'] = $nome;
    $_SESSION['cliente_email'] = $email;
    $_SESSION['cliente_cpf'] = $cpf;
    $_SESSION['cliente_telefone'] = $telefone;

    header('Location: agendamento.php');
    exit;
} else {
    $_SESSION['register_err'] = 'Erro ao criar conta: ' . mysqli_error($conn);
    header('Location: register.php');
    exit;
}
?>
