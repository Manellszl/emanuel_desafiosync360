<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/estilo.css">
  <title>Atualizar Perfil</title>
</head>

<body>
  <!-- Formulário para enviar imagem para atualização de perfil -->
  <form id="atualizarPerfil" action="upload.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="foto_perfil" id="foto_perfil" accept="image/*" required>
  <br/>
  <br/>
  <input class="confirmar" type="submit" value="Confirmar" />
  </form>

  <script src="js/app.js"></script>
</body>

</html>