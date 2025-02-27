<?php
session_start();
include 'conexao.php'; 

$sql = "SELECT * FROM produtos"; 
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    $produtos = [];
    while($row = $resultado->fetch_assoc()) {
        $produtos[] = [
            'nome' => $row['nome'],
            'preco' => $row['preco'],
            'imagem' => $row['imagem']
        ];
    }
} else {
    $produtos = [];
}

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = [];
}

if (isset($_POST['adicionar'])) {
    $produto = [
        'nome' => $_POST['nome'],
        'preco' => $_POST['preco']
    ];
    $_SESSION['carrinho'][] = $produto;
}

$termoBusca = '';
$resultados = $produtos;

if (isset($_GET['busca']) && !empty($_GET['busca'])) {
    $termoBusca = strtolower($_GET['busca']);
    $resultados = array_filter($produtos, function ($produto) use ($termoBusca) {
        return strpos(strtolower($produto['nome']), $termoBusca) !== false;
    });
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papel & Cia</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <header>
        <img src="images/logo.jpeg" alt="Logo Papel & Cia" class="logo">
        <form method="GET" action="index.php" class="search-form">
            <input type="text" name="busca" placeholder="Digite o que você procura" class="search-bar" value="<?= htmlspecialchars($termoBusca) ?>">
            <button type="submit">🔍</button>
        </form>
    </header>

    <main>
        <h2>Materiais escolares</h2>
        <div class="produtos">
            <?php if (empty($resultados)): ?>
                <p>Nenhum produto encontrado para "<?= htmlspecialchars($termoBusca) ?>".</p>
            <?php else: ?>
                <?php foreach ($resultados as $produto): ?>
                    <div class="produto">
                        <img src="<?= $produto['imagem'] ?>" alt="<?= $produto['nome'] ?>">
                        <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                        <p>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                        <form method="POST">
                            <input type="hidden" name="nome" value="<?= $produto['nome'] ?>">
                            <input type="hidden" name="preco" value="<?= $produto['preco'] ?>">
                            <button type="submit" name="adicionar">Adicionar ao Carrinho</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <a href="carrinho.php" class="btn">Ir para o Carrinho</a>
    </main>
</body>
</html>