<?php
session_start();
session_destroy(); // Encerra todas as sessões
header("Location: index.php"); // Redireciona para a página inicial
exit;
?>
