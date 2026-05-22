<?php
require_once 'config/conexao.php';
require_once 'includes/header.php';

$stmt = $pdo->query("SELECT * FROM produtos ORDER BY nome ASC");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Estoque da Farmácia</h2>

<!-- Exibe a mensagem de sucesso ou erro (Flash Message) -->
<?php if (isset($_SESSION['mensagem'])): ?>
    <div class="alerta">
        <p><strong><?php echo $_SESSION['mensagem']; ?></strong></p>
    </div>
    <?php unset($_SESSION['mensagem']); // Limpa a mensagem após exibir ?>
<?php endif; ?>

<div class="acoes-topo">
    <a href="cadastro.php" class="btn-primario">➕ Novo Produto</a>
</div>

<?php if (count($produtos) > 0): ?>
    <!-- Estrutura em Grid/Cards ideal para Mobile First -->
    <div class="grid-produtos">
        <?php foreach ($produtos as $produto): ?>
            <article class="card-produto">
                <div class="card-info">
                    <h3><?php echo htmlspecialchars($produto['nome']); ?></h3>
                    <p class="fabricante">Fabricante: <?php echo htmlspecialchars($produto['fabricante']); ?></p>
                    <p class="preco">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                    <p class="estoque">Estoque: <strong><?php echo $produto['estoque']; ?> un.</strong></p>
                </div>
                <div class="card-acoes">
                    <a href="editar.php?id=<?php echo $produto['id']; ?>" class="btn-editar">✏️ Editar</a>
                    <a href="excluir.php?id=<?php echo $produto['id']; ?>" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir <?php echo htmlspecialchars($produto['nome']); ?>?')">🗑️ Excluir</a>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="estado-vazio">Nenhum produto cadastrado. Adicione o primeiro medicamento!</p>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>