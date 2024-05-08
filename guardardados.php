<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilo.css"> 
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
$rua = $_POST['rua'];
$bairro = $_POST['bairro'];
$estado = $_POST['estado'];
$bio = $_POST['bio'];

// Primeiro, vamos verificar se há registros existentes
$sql = "SELECT id FROM dados_perfil WHERE nome = ?"; // Altere a cláusula WHERE conforme necessário
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nome);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Se houver registros, fazemos um UPDATE
    $registro = $result->fetch_assoc(); // Obtém o primeiro registro
    $id = $registro['id']; // ID do registro para ser atualizado

    $update_sql = "UPDATE dados_perfil SET idade = ?, rua = ?, bairro = ?, estado = ?, bio = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("issssi", $idade, $rua, $bairro, $estado, $bio, $id);

    if ($stmt->execute()) {
        echo "<div class='success-message-wrapper'>
                <div class='success-message'>Dados atualizados com sucesso!</div>
              </div>";
        header("Refresh: 2; url=index.php");
        exit;
    } else {
        echo "Erro ao atualizar dados: " . $stmt->error;
    }
} else {
    // Se não houver registros, fazemos um INSERT
    $insert_sql = "INSERT INTO dados_perfil (nome, idade, rua, bairro, estado, bio) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("sissss", $nome, $idade, $rua, $bairro, $estado, $bio);

    if ($stmt->execute()) {
        echo "<div class='success-message-wrapper'>
                <div class='success-message'>Dados inseridos com sucesso!</div>
              </div>";
        header("Refresh: 2; url=index.php");
        exit;
    } else {
        echo "Erro ao inserir dados: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>

</body>
</html>
