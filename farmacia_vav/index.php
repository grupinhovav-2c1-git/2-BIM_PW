<?php
require_once 'config/conexao.php';
require_once 'includes/header.php';

// Busca os produtos
$stmt = $pdo->query("SELECT * FROM produtos ORDER BY nome ASC");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Lista de Produtos em Estoque</h2>

<?php if (count($produtos) > 0): ?>
    <!-- Sugestão Mobile First: A tabela pode ser escondida no CSS em telas menores e os blocos/cards exibidos -->
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Fabricante</th>
                <th>Preço</th>
                <th>Estoque</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produtos as $produto): ?>
                <tr>
                    <td><?php echo $produto['id']; ?></td>
                    <td><?php echo htmlspecialchars($produto['nome']); ?></td>
                    <td><?php echo htmlspecialchars($produto['fabricante']); ?></td>
                    <td>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                    <td><?php echo $produto['estoque']; ?> un.</td>
                    <td>
                        <a href="editar.php?id=<?php echo $produto['id']; ?>">Editar</a> | 
                        <a href="excluir.php?id=<?php echo $produto['id']; ?>" onclick="return confirm('Deseja realmente excluir este produto?')">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Nenhum produto cadastrado no momento.</p>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>