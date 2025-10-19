<?php
// Substitua 'admin123' pela senha que você quer para o admin
$senha = 'tpxizzy';
$hash = password_hash($senha, PASSWORD_DEFAULT);
echo "Hash da senha: $hash\n";
