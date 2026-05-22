<?php
require_once 'config/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $fabricante = trim($_POST['fabricante'] ?? '');
    $preco = $_POST['preco'] ?? 0;
    $estoque = $_POST['estoque'] ?? 0;

    if (!empty($nome) && !empty($fabricante)) {
        $sql = "INSERT INTO produtos (nome, fabricante, preco, estoque) VALUES (:nome, :fabricante, :preco, :estoque)";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':fabricante', $fabricante);
        $stmt->bindValue(':preco', $preco);
        $stmt->bindValue(':estoque', $estoque);

        if ($stmt->execute()) {
            $_SESSION['mensagem'] = "✅ Produto cadastrado com sucesso!";
            header("Location: index.php"); // Redireciona para evitar F5 (reenvio de form)
            exit;
        } else {
            $erro = "Erro ao salvar no banco de dados.";
        }
    } else {
        $erro = "Preencha todos os campos obrigatórios.";
    }
}

require_once 'includes/header.php';
?>

<h2>Cadastrar Medicamento / Produto</h2>

<?php if (isset($erro)): ?>
    <p class="alerta-erro"><strong><?php echo $erro; ?></strong></p>
<?php endif; ?>

<form action="cadastro.php" method="POST" class="formulario">
    <div class="campo">
        <label for="nome">Nome do Produto:</label>
        <input type="text" id="nome" name="nome" placeholder="Ex: Paracetamol 500mg" required>
    </div>
    
    <div class="campo">
        <label for="fabricante">Fabricante / Laboratório:</label>
        <input type="text" id="fabricante" name="fabricante" placeholder="Ex: Medley" required>
    </div>
    
    <div class="campo">
        <label for="preco">Preço de Venda (R$):</label>
        <input type="number" id="preco" name="preco" step="0.01" min="0.01" placeholder="0,00" required>
    </div>
    
    <div class="campo">
        <label for="estoque">Qtd. em Estoque:</label>
        <input type="number" id="estoque" name="estoque" min="0" placeholder="Ex: 50" required>
    </div>
    
    <div class="botoes-form">
        <button type="submit" class="btn-salvar">Salvar Produto</button>
        <a href="index.php" class="btn-cancelar">Cancelar</a>
    </div>
</form>

<?php require_once 'includes/footer.php'; ?>