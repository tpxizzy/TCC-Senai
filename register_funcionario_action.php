<?php
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit;
}

// Recebe dados do formulário
$nome        = trim($_POST['nome']);
$email       = trim($_POST['email']);
$senha       = $_POST['senha'];
$ra          = trim($_POST['ra']);
$cpf         = trim($_POST['cpf']);
$senha_admin = trim($_POST['senha_admin']);

// Validação básica
if (empty($nome) || empty($email) || empty($senha) || empty($ra) || empty($cpf) || empty($senha_admin)) {
    echo "<script>alert('Por favor, preencha todos os campos!'); window.history.back();</script>";
    exit;
}

// Verifica senha do administrador no banco
$adminUser = 'Christian'; // seu admin
$stmt = $conn->prepare("SELECT senha_hash FROM administradores WHERE username = ? LIMIT 1");
$stmt->bind_param("s", $adminUser);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    echo "<script>alert('Administrador não encontrado.'); window.history.back();</script>";
    exit;
}

$row = $res->fetch_assoc();
$admin_hash = $row['senha_hash'];
$stmt->close();

if (!password_verify($senha_admin, $admin_hash)) {
    echo "<script>alert('Senha do administrador incorreta!'); window.history.back();</script>";
    exit;
}

// Verifica se o e-mail do funcionário já existe
$stmt = $conn->prepare("SELECT id FROM funcionarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    echo "<script>alert('E-mail já cadastrado!'); window.history.back();</script>";
    exit;
}

// Cria hash da senha do funcionário
$senha_hash_func = password_hash($senha, PASSWORD_DEFAULT);

// Insere novo funcionário
$stmt = $conn->prepare("INSERT INTO funcionarios (nome, email, senha, ra, cpf) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $nome, $email, $senha_hash_func, $ra, $cpf);

if ($stmt->execute()) {
    echo "<script>alert('Funcionário cadastrado com sucesso!'); window.location.href='login.php';</script>";
} else {
    echo "<script>alert('Erro ao cadastrar funcionário! Tente novamente.'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>
