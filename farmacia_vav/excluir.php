<?php
require_once 'config/conexao.php';

$id = $_GET['id'] ?? null;

if ($id) {
    // Exclui com segurança usando Prepare
    $sql = "DELETE FROM produtos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
}

// Redireciona de volta para a página principal
header("Location: index.php");
exit;
?>