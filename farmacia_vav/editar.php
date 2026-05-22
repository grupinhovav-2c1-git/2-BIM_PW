<?php
require_once 'config/conexao.php';

$id = $_GET['id'] ?? null;
$mensagem = "";

if (!$id) {
    header("Location: index.php");
    exit;
}

// Processa a atualização
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $fabricante = $_POST['fabricante'] ?? '';
    $preco = $_POST['preco'] ?? 0;
    $estoque = $_POST['estoque'] ?? 0;

    $sql = "UPDATE produtos SET nome = :nome, fabricante = :fabricante, preco = :preco, estoque = :estoque WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':nome', $nome);
    $stmt->bindValue(':fabricante', $fabricante);
    $stmt->bindValue(':preco', $preco);
    $stmt->bindValue(':estoque', $estoque);
    $stmt->bindValue(':id', $id);

    if ($stmt->execute()) {
        $mensagem = "Produto atualizado com sucesso!";
    } else {
        $mensagem = "Erro ao atualizar produto.";
    }
}

// Busca os dados atuais do produto para preencher o formulário
$sql = "SELECT * FROM produtos WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id);
$stmt->execute();
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    die("Produto não encontrado.");
}

require_once 'includes/header.php';
?>

<h2>Editar Produto</h2>

<?php if (!empty($mensagem)): ?>
    <p><strong><?php echo $mensagem; ?></strong></p>
<?php endif; ?>

<form action="editar.php?id=<?php echo $id; ?>" method="POST">
    <div>
        <label for="nome">Nome do Produto:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($produto['nome']); ?>" required>
    </div>
    
    <div>
        <label for="fabricante">Fabricante:</label>
        <input type="text" id="fabricante" name="fabricante" value="<?php echo htmlspecialchars($produto['fabricante']); ?>" required>
    </div>
    
    <div>
        <label for="preco">Preço (R$):</label>
        <input type="number" id="preco" name="preco" step="0.01" min="0" value="<?php echo $produto['preco']; ?>" required>
    </div>
    
    <div>
        <label for="estoque">Quantidade em Estoque:</label>
        <input type="number" id="estoque" name="estoque" min="0" value="<?php echo $produto['estoque']; ?>" required>
    </div>
    
    <button type="submit">Atualizar Produto</button>
</form>

<p><a href="index.php">Voltar para a listagem</a></p>

<?php require_once 'includes/footer.php'; ?>