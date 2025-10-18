<?php
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recebe e limpa os dados do formulário
    $nome  = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // criptografa a senha
    $ra    = trim($_POST['ra']);
    $cpf   = trim($_POST['cpf']);

    // Validação básica
    if (empty($nome) || empty($email) || empty($_POST['senha']) || empty($ra) || empty($cpf)) {
        echo "<script>alert('Por favor, preencha todos os campos!'); window.history.back();</script>";
        exit;
    }

    // Verifica se o e-mail já existe
    $checkEmail = $conn->prepare("SELECT id FROM funcionarios WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('E-mail já cadastrado!'); window.location.href='login.php';</script>";
        exit;
    }

    // Insere novo funcionário
    $sql = "INSERT INTO funcionarios (nome, email, senha, ra, cpf) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nome, $email, $senha, $ra, $cpf);

    if ($stmt->execute()) {
        echo "<script>alert('Funcionário cadastrado com sucesso!'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar funcionário! Tente novamente.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();

} else {
    // Redireciona caso o acesso não seja via POST
    header("Location: login.php");
    exit;
}
?>
