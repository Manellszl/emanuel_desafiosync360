<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dados";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Diretório onde as imagens serão armazenadas
$uploadDir = "img/capa/";

// Verifica se um arquivo foi enviado e se não houve erro durante o upload
if (isset($_FILES["capa"]) && $_FILES["capa"]["error"] === UPLOAD_ERR_OK) {
    $file = $_FILES["capa"];  // Objeto que representa o arquivo carregado
    $fileName = uniqid() . "_" . basename($file["name"]);  // Nome único para o arquivo
    $uploadFile = $uploadDir . $fileName;  // Caminho completo para o arquivo

    // Cria o diretório se não existir
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Move o arquivo para o diretório especificado
    if (move_uploaded_file($file["tmp_name"], $uploadFile)) {
        // Insere o caminho do arquivo no banco de dados
        $sql = "INSERT INTO capa (caminho) VALUES (?)";  // Query para inserir o caminho
        $stmt = $conn->prepare($sql);  // Preparação da declaração SQL
        $stmt->bind_param("s", $uploadFile);  // Associação do parâmetro

        // Verifica se a operação foi bem-sucedida
        if ($stmt->execute()) {
            echo "Foto atualizada com sucesso!";
            header("Refresh: 0; url=index.php"); // Redireciona para a página principal

        } else {
            echo "Erro ao salvar o caminho da imagem no banco de dados.";
            header("Refresh: 1; url=index.php");
        }

        $stmt->close();  // Fecha a instrução preparada
    } else {
        echo "Erro ao mover a imagem para o diretório.";
        header("Refresh: 1; url=index.php");
    }
} else {
    echo "Nenhum arquivo foi enviado ou ocorreu um erro.";
    header("Refresh: 1; url=index.php");
}

$conn->close(); 
?>
