<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css"> 
    <title>Atualizar Perfil</title>
</head>
<body>
    <!-- Formulário para enviar imagem para atualização de perfil -->
    <form action="upload.php" method="POST" enctype="multipart/form-data"> 
        <label for="imagem">Atualizar foto de perfil</label> 
        
        <!-- Campo de seleção de arquivo, aceitando apenas imagens -->
        <input type="file" name="imagem" id="imagem" accept="image/*"/> 
        
        <br/> 

        <input class="confirmar" type="submit" value="Confirmar"/> 
    </form>

    <script src="app.js"></script> 
</body>
</html>
