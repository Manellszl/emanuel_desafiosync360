<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dados"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Diretório onde os arquivos de imagem serão armazenados
$uploadDir = "img/"; 

// Verifica se um arquivo foi enviado e se não houve erro durante o upload
if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] === UPLOAD_ERR_OK) {
    $file = $_FILES["imagem"];
    
    // Cria um nome único para o arquivo para evitar conflitos
    $fileName = uniqid() . "_" . basename($file["name"]);
    
    // Caminho completo para onde o arquivo será movido
    $uploadFile = $uploadDir . $fileName; 

    // Verifica se o diretório de upload existe, se não, cria-o
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Move o arquivo para o diretório de upload
    if (move_uploaded_file($file["tmp_name"], $uploadFile)) {
        // Insere o caminho do arquivo no banco de dados
        $sql = "INSERT INTO imagens (caminho) VALUES (?)";
        $stmt = $conn->prepare($sql); // Prepara a consulta SQL
        $stmt->bind_param("s", $uploadFile); // Vincula o caminho do arquivo à consulta

        if ($stmt->execute()) {
            // Mensagem de sucesso ao atualizar a imagem
            echo "Foto atualizada com sucesso!";
            
            // Uso do script para fechar o iframe no pai
            echo "<script>
                    window.parent.postMessage('fecharIframe', '*');
                  </script>";
        } else {
            echo "Erro ao salvar o caminho da imagem no banco de dados.";
        }

        $stmt->close(); // Fecha a instrução preparada
    } else {
        echo "Erro ao mover a imagem para o diretório.";
    }
} else {
    // Mensagem se nenhum arquivo foi enviado ou houve erro no upload
    echo "Nenhum arquivo foi enviado ou ocorreu um erro.";
    // Redireciona para a página anterior após 1 segundo
    header("Refresh: 1; url=iframe.php");
}

$conn->close(); 
?>
