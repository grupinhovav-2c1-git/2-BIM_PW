<?php
require_once 'config/conexao.php';

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $fabricante = $_POST['fabricante'] ?? '';
    $preco = $_POST['preco'] ?? 0;
    $estoque = $_POST['estoque'] ?? 0;

    if (!empty($nome) && !empty($fabricante)) {
        // Proteção contra SQL Injection usando Prepared Statements
        $sql = "INSERT INTO produtos (nome, fabricante, preco, estoque) VALUES (:nome, :fabricante, :preco, :estoque)";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':fabricante', $fabricante);
        $stmt->bindValue(':preco', $preco);
        $stmt->bindValue(':estoque', $estoque);

        if ($stmt->execute()) {
            $mensagem = "Produto cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar o produto.";
        }
    } else {
        $mensagem = "Por favor, preencha todos os campos obrigatórios.";
    }
}

require_once 'includes/header.php';
?>

<h2>Cadastrar Novo Produto</h2>

<?php if (!empty($mensagem)): ?>
    <p><strong><?php echo $mensagem; ?></strong></p>
<?php endif; ?>

<form action="cadastro.php" method="POST">
    <div>
        <label for="nome">Nome do Produto:</label>
        <input type="text" id="nome" name="nome" required>
    </div>
    
    <div>
        <label for="fabricante">Fabricante:</label>
        <input type="text" id="fabricante" name="fabricante" required>
    </div>
    
    <div>
        <label for="preco">Preço (R$):</label>
        <input type="number" id="preco" name="preco" step="0.01" min="0" required>
    </div>
    
    <div>
        <label for="estoque">Quantidade em Estoque:</label>
        <input type="number" id="estoque" name="estoque" min="0" required>
    </div>
    
    <button type="submit">Salvar Produto</button>
</form>

<?php require_once 'includes/footer.php'; ?>