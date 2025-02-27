<?php
session_start();
include 'conexao.php'; // Inclui o arquivo de conexão

// Verifica se o carrinho está vazio antes de prosseguir
if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
    echo "<script>alert('Seu carrinho está vazio! Adicione produtos antes de prosseguir.'); window.location.href='index.php';</script>";
    exit;
}

// Processar o formulário de envio
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $destinatario = $conn->real_escape_string($_POST['destinatario']);
    $telefone = $conn->real_escape_string($_POST['telefone']);
    $cep = $conn->real_escape_string($_POST['cep']);
    $endereco = $conn->real_escape_string($_POST['endereco']);
    $numero = $conn->real_escape_string($_POST['numero']);
    $bairro = $conn->real_escape_string($_POST['bairro']);
    $metodo = $conn->real_escape_string($_POST['metodo']);

    // Insere os dados no banco
    $sql = "INSERT INTO envio (destinatario, telefone, cep, endereco, numero, bairro, metodo) 
            VALUES ('$destinatario', '$telefone', '$cep', '$endereco', '$numero', '$bairro', '$metodo')";

    if ($conn->query($sql) === TRUE) {
        // Armazena o ID do envio na sessão para ser usado na próxima etapa (pagamento)
        $_SESSION['envio_id'] = $conn->insert_id;

        // Redireciona para a página de pagamento
        header("Location: pagamento.php");
        exit;
    } else {
        echo "<script>alert('Erro ao salvar os dados de envio.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envio</title>
    <link rel="stylesheet" href="style.css?v=1">
</head>
<body>
    <header>
        <img src="images/logo.jpeg" alt="Logo Papel & Cia" class="logo">
    </header>

    <main>
        <h2>Informações de envio</h2>
        <form action="envio.php" method="POST" onsubmit="return validarCampos()">
            <label for="destinatario">Destinatário *</label>
            <input type="text" name="destinatario" id="destinatario" placeholder="Ex: João Silva" required>

            <label for="telefone">Telefone *</label>
            <input type="text" name="telefone" id="telefone" placeholder="Ex: (11) 98765-4321" required>

            <label for="cep">CEP *</label>
            <input type="text" name="cep" id="cep" placeholder="Ex: 12345-678" required>

            <label for="endereco">Endereço *</label>
            <input type="text" name="endereco" id="endereco" placeholder="Ex: Rua das Flores, 123" required>

            <div class="input-group">
                <label for="numero">Número</label>
                <input type="text" name="numero" id="numero" placeholder="Ex: 123" required>
                <label for="bairro">Bairro *</label>
                <input type="text" name="bairro" id="bairro" placeholder="Ex: Centro" required>
            </div>

            <h3>Método de envio *</h3>
            <label><input type="radio" name="metodo" value="Correios" required> Correios</label>
            <label><input type="radio" name="metodo" value="Transportadora" required> Transportadora</label>

            <button type="submit">IR PARA O PAGAMENTO</button>
        </form>

        <div id="erro" style="color: red; display: none;">
            <p>Por favor, preencha todos os campos obrigatórios (*) antes de continuar.</p>
        </div>
    </main>

    <script>
        function validarCampos() {
            var camposObrigatorios = document.querySelectorAll('input[required]');
            var erro = document.getElementById('erro');
            for (var i = 0; i < camposObrigatorios.length; i++) {
                if (camposObrigatorios[i].value === "") {
                    erro.style.display = "block";
                    return false; // Não submete o formulário
                }
            }
            erro.style.display = "none"; // Oculta o erro se tudo estiver preenchido
            return true; // Permite o envio do formulário
        }
    </script>
</body>
</html>