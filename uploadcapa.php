<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dados"; // Nome do banco de dados

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Diretório onde as imagens de capa serão armazenadas
$uploadDir = "img/capa/";

// Verifica se um arquivo foi enviado
if (isset($_FILES["capa"]) && $_FILES["capa"]["error"] === UPLOAD_ERR_OK) {
    $file = $_FILES["capa"];
    $fileName = uniqid() . "_" . basename($file["name"]);  // Nome único para evitar conflitos
    $uploadFile = $uploadDir . $fileName;  // Caminho para onde a imagem será movida

    // Verifica se o diretório existe, se não, cria-o
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Move o arquivo para o diretório de destino
    if (move_uploaded_file($file["tmp_name"], $uploadFile)) {
        // Verifica a quantidade de registros na tabela
        $sqlCheck = "SELECT COUNT(*) AS count FROM capa";  // Consulta para contar os registros
        $result = $conn->query($sqlCheck);
        $count = ($result->num_rows > 0) ? $result->fetch_assoc()["count"] : 0;

        if ($count == 0) {  // Se não houver registros, insere
            $sql = "INSERT INTO capa (caminho) VALUES (?)";
        } else {  // Se houver registros, atualiza
            $sql = "UPDATE capa SET caminho = ? WHERE id = (SELECT MIN(id) FROM capa)";
        }

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $uploadFile);

        if ($stmt->execute()) {
            echo "Capa atualizada com sucesso!";
            echo "<script>setTimeout(function() { window.location.href = 'index.php'; }, 1);</script>";
        } else {
            echo "Erro ao atualizar o banco de dados.";
            echo "<script>setTimeout(function() { window.location.href = 'index.php'; }, 2);</script>";  
        }

        $stmt->close(); 
    } else {
        echo "Erro ao mover a imagem para o diretório.";
        echo "<script>setTimeout(function() { window.location.href = 'index.php'; }, 2);</script>";
    }
} else {
    echo "Nenhum arquivo foi enviado ou ocorreu um erro.";
    echo "<script>setTimeout(function() { window.location.href = 'index.php'; }, 2);</script>";
}

$conn->close(); 
?>
