<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" href="estilo.css"> 
    <title>Dados Atualizados</title>
</head>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dados"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Obter dados do formulário
$nome = $_POST['nome']; 
$idade = (int) $_POST['idade']; 
$endereco = $_POST['endereco']; 
$bio = $_POST['bio'];

// Inserção de dados no banco de dados
$sql = "INSERT INTO dados_perfil (nome, idade, endereco, bio) VALUES ('$nome', $idade, '$endereco', '$bio')";

// Verificação se a inserção foi bem-sucedida
if ($conn->query($sql) === TRUE) {
    // Mensagem de sucesso ao atualizar dados
    echo "<div class='success-message-wrapper'>
            <div class='success-message'>Dados atualizados com sucesso!</div>
          </div>";
    
    // Redirecionamento para a página principal após 2 segundos
    header("Refresh: 2; url=index.php"); 
    exit; // Termina o script após o redirecionamento
} else {
    // Mensagem de erro ao atualizar dados
    echo "Erro ao atualizar dados: " . $conn->error;
    
    // Redirecionamento para a página principal após 1 segundo
    header("Refresh: 1; url=index.php");
}

$conn->close();
?>

</body>
</html>
