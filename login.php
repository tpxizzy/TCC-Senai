<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login Funcionário - Petshop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>
<body>
    <div class="container" style="max-width: 400px; margin-top: 100px;">
        <h2 class="mb-4 text-center">Login Funcionário</h2>
        <form action="validar.php" method="post">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input 
                    type="email" 
                    class="form-control" 
                    id="email" 
                    name="email" 
                    placeholder="Digite seu e-mail" 
                    required 
                />
            </div>
            <div class="form-group">
                <label for="senha">Senha</label>
                <input 
                    type="password" 
                    class="form-control" 
                    id="senha" 
                    name="senha" 
                    placeholder="Digite sua senha" 
                    required 
                />
            </div>
            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
        </form>
        <div class="text-center mt-3">
            <a href="index.php" class="btn btn-secondary">Voltar para o início</a>
        </div>
    </div>
</body>
</html>
