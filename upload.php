<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dados"; // Nome do banco de dados

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Diretório onde os arquivos de imagem serão armazenados
$uploadDir = "img/perfil/"; 

// Verifique se o arquivo foi enviado com sucesso
if (isset($_FILES["foto_perfil"]) && $_FILES["foto_perfil"]["error"] === UPLOAD_ERR_OK) {
    $file = $_FILES["foto_perfil"];
    
    // Cria um nome único para o arquivo para evitar conflitos
    $fileName = uniqid() . "_" . basename($file["name"]);
    
    // Caminho completo para onde o arquivo será movido
    $uploadFile = $uploadDir . $fileName; 

    // Verifica se o diretório de upload existe, se não, cria-o 
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Define permissões de gravação
    }

    // Move o arquivo para o diretório de upload
    if (move_uploaded_file($file["tmp_name"], $uploadFile)) {
        // Insere ou atualiza o caminho do arquivo no banco de dados
        $sql = "SELECT id FROM imagens ORDER BY data_upload DESC LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Se houver registros, atualiza o caminho da imagem
            $registro = $result->fetch_assoc();
            $update_sql = "UPDATE imagens SET caminho = ?, data_upload = NOW() WHERE id = ?";
            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param("si", $uploadFile, $registro["id"]);

            if ($stmt->execute()) {
                echo "Foto de perfil atualizada com sucesso!";
                echo "<script>window.parent.postMessage('fecharIframe', '*');</script>";
            } else {
                echo "Erro ao atualizar a foto de perfil: " . $stmt->error;
            }
        } else {
            // Se não houver registros, insere um novo
            $insert_sql = "INSERT INTO imagens (caminho, data_upload) VALUES (?, NOW())";
            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param("s", $uploadFile);

            if ($stmt->execute()) {
                echo "Foto de perfil inserida com sucesso!";
                echo "<script>window.parent.postMessage('fecharIframe', '*');</script>";
            } else {
                echo "Erro ao inserir a foto de perfil: " . $stmt->error;
            }
        }

        $stmt->close(); // Fecha a instrução preparada
    } else {
        echo "Erro ao mover a imagem para o diretório.";
    }
} else {
    echo "Nenhum arquivo foi enviado ou ocorreu um erro durante o upload.";
}

$conn->close(); // Fecha a conexão com o banco de dados
?>
