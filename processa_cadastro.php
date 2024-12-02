<?php
<form method="POST" action="{{ route('register') }}">
    @csrf
    <button type="submit">Cadastrar</button>
</form>
// Carrega as credenciais do banco de dados de um arquivo de configuração (recomendado)
require_once 'config.php';

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validação dos dados (exemplo básico)
$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

// Sanitização dos dados (importante para evitar XSS)
$nome = htmlspecialchars($nome, ENT_QUOTES);
$email = filter_var($email, FILTER_SANITIZE_EMAIL);

// Prepared statement para evitar injeção SQL
$stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nome, $email, password_hash($senha, PASSWORD_DEFAULT));

if ($stmt->execute()) {
    echo "Novo usuário criado com sucesso!";
} else {
    echo "Erro ao criar usuário: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
