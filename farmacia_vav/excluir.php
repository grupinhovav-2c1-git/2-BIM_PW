<?php
require_once 'config/conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id) {
    $sql = "DELETE FROM produtos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    
    if ($stmt->execute()) {
        $_SESSION['mensagem'] = "🗑️ Produto removido do estoque.";
    } else {
        $_SESSION['mensagem'] = "❌ Erro ao remover o produto.";
    }
}

header("Location: index.php");
exit;
?>