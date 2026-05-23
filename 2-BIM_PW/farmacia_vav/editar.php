<?php
require_once 'config/conexao.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    $_SESSION['mensagem'] = "❌ Produto inválido.";
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $fabricante = trim($_POST['fabricante'] ?? '');
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
        $_SESSION['mensagem'] = "✅ Produto atualizado com sucesso!";
        header("Location: index.php");
        exit;
    } else {
        $erro = "Erro ao atualizar produto.";
    }
}

$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = :id");
$stmt->bindValue(':id', $id);
$stmt->execute();
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    $_SESSION['mensagem'] = "❌ Produto não encontrado.";
    header("Location: index.php");
    exit;
}

require_once 'includes/header.php';
?>

<h2>Editar Produto</h2>

<?php if (isset($erro)): ?>
    <p class="alerta-erro"><strong><?php echo $erro; ?></strong></p>
<?php endif; ?>

<form action="editar.php?id=<?php echo $id; ?>" method="POST" class="formulario">
    <div class="campo">
        <label for="nome">Nome do Produto:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($produto['nome']); ?>" required>
    </div>
    
    <div class="campo">
        <label for="fabricante">Fabricante:</label>
        <input type="text" id="fabricante" name="fabricante" value="<?php echo htmlspecialchars($produto['fabricante']); ?>" required>
    </div>
    
    <div class="campo">
        <label for="preco">Preço (R$):</label>
        <input type="number" id="preco" name="preco" step="0.01" min="0.01" value="<?php echo $produto['preco']; ?>" required>
    </div>
    
    <div class="campo">
        <label for="estoque">Estoque:</label>
        <input type="number" id="estoque" name="estoque" min="0" value="<?php echo $produto['estoque']; ?>" required>
    </div>
    
    <div class="botoes-form">
        <button type="submit" class="btn-salvar">Atualizar Produto</button>
        <a href="index.php" class="btn-cancelar">Voltar</a>
    </div>
</form>

<?php require_once 'includes/footer.php'; ?>