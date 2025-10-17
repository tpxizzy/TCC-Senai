<?php
session_start();
require_once 'conexao.php';

// Verifica se funcionário está logado
if (!isset($_SESSION['funcionario_id'])) {
    header("Location: login.php");
    exit;
}

// Verifica se o ID do cliente foi passado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: funcionarios.php");
    exit;
}

$cliente_id = intval($_GET['id']);

// Buscar dados atuais do cliente
$stmt = $conn->prepare("SELECT * FROM clientes WHERE id = ?");
$stmt->bind_param("i", $cliente_id);
$stmt->execute();
$result = $stmt->get_result();
$cliente = $result->fetch_assoc();

if (!$cliente) {
    $_SESSION['msg'] = "Cliente não encontrado.";
    header("Location: funcionarios.php");
    exit;
}

// Atualizar dados do cliente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome_completo'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $cpf = $_POST['cpf'] ?? '';

    if (empty($nome) || empty($email) || empty($telefone) || empty($cpf)) {
        $erro = "Por favor, preencha todos os campos.";
    } else {
        $update_stmt = $conn->prepare("UPDATE clientes SET nome_completo = ?, email = ?, telefone = ?, cpf = ? WHERE id = ?");
        $update_stmt->bind_param("ssssi", $nome, $email, $telefone, $cpf, $cliente_id);
        if ($update_stmt->execute()) {
            $_SESSION['msg'] = "Dados do cliente atualizados com sucesso!";
            header("Location: funcionarios.php");
            exit;
        } else {
            $erro = "Erro ao atualizar dados: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Editar Cliente - Petshop</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
<style>
    body { background-color: #f7f9fc; font-family: 'Arial', sans-serif; }
    .container { max-width: 600px; margin-top: 50px; }
    .card { border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    .btn-success { background-color: #28a745; border: none; }
    .btn-success:hover { background-color: #218838; }
    .btn-secondary { background-color: #6c757d; border: none; color: white; }
    .btn-secondary:hover { background-color: #5a6268; }
</style>
</head>
<body>

<div class="container">
    <div class="card p-4">
        <h3 class="text-center mb-4">Editar Cliente</h3>

        <?php if(isset($erro)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Nome Completo</label>
                <input type="text" name="nome_completo" class="form-control" value="<?= htmlspecialchars($cliente['nome_completo']) ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($cliente['email']) ?>" required>
            </div>
            <div class="form-group">
                <label>Telefone</label>
                <input type="text" name="telefone" class="form-control" value="<?= htmlspecialchars($cliente['telefone']) ?>" required>
            </div>
            <div class="form-group">
                <label>CPF</label>
                <input type="text" name="cpf" class="form-control" value="<?= htmlspecialchars($cliente['cpf']) ?>" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success">Salvar Alterações</button>
                <a href="funcionarios.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
