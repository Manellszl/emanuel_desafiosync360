<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dados"; 


$conn = new mysqli($servername, $username, $password, $dbname);

// Verificação de conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Obter a última imagem do banco de dados para capa e ícone do usuário
$sqlUltimaImagem = "SELECT caminho FROM imagens ORDER BY data_upload DESC LIMIT 1";
$resultImagem = $conn->query($sqlUltimaImagem);

$sqlUltimaCapa = "SELECT caminho FROM capa ORDER BY data_upload DESC LIMIT 1";
$resultCapa = $conn->query($sqlUltimaCapa);

// Caminhos padrão para capa e imagem do usuário
$caminhoCapa = "img/capa/iconebanner.png";
$caminhoImagem = "img/perfil/iconeusuario.png"; 

// Se houver uma imagem de usuário, usamos o caminho obtido
if ($resultImagem && $resultImagem->num_rows > 0) {
    $registroImagem = $resultImagem->fetch_assoc();
    $caminhoImagem = $registroImagem["caminho"];
}

// Se houver uma capa, usamos o caminho obtido
if ($resultCapa && $resultCapa->num_rows > 0) {
    $registroCapa = $resultCapa->fetch_assoc();
    $caminhoCapa = $registroCapa["caminho"];
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Hepta+Slab:wght@400&display=swap">
    <link rel="stylesheet" href="css/estilo.css">
    <title>Desafio Emanuel</title>
</head>

<body>
    <!-- Cabeçalho com imagem de capa -->
    <header
        style="background-image: url('<?php echo $caminhoCapa; ?>'); background-position: center; background-repeat: no-repeat; background-size: cover;">

        <!-- Imagem do usuário e opções para alterar -->
        <div class="foto">
            <img id="foto_usuario" src="<?php echo $caminhoImagem; ?>" alt="Usuário">
        </div>
        <div class="mudafoto">
            <img id="trocafoto" src="img/perfil/iconefoto.png" alt="Trocar foto do usuário">
            <input type="button" value="Exibir Iframe" onclick="exibirIframe();" class="btniframe" />
            <p class="altfoto">Alterar</p>
        </div>

        <!-- Seção para exibir/fechar o iframe -->
        <div class="iframeimg">
            <iframe id="iframe" src="iframe.php"></iframe>
            <input type="button" value="Fechar" id="fecharbtn" class="fechariframe" onclick="fecharIframe();" name="Fechar" />
        </div>

        <!-- Opção para troca de tema -->
        <div class="banner">
            <div class="tema">
                <input type="checkbox" class="checkbox" id="chk" />
                <label class="labeltema" for="chk">
                    <img class="fas fa-moon" src="img/fa-moon.png" />
                    <img class="fas fa-sun" src="img/fa-sun.png" />
                    <div class="ball"></div>
                </label>
            </div>
        </div>
    </header>

    <div class="hr"></div>

    <!-- Corpo principal do site -->
    <article id="conteudo">

        <!-- Seção para troca de capa -->
        <div id="troca_capa">
            <form id="trocacapa" action="uploadCapa.php" method="post" enctype="multipart/form-data">
                <label class="labcapa" for="arquivocapa" tabindex="0">
                    <input id="arquivocapa" type="file" name="capa" accept="image/*">
                    <span id="atucapa" onclick="exibirButton();">Atualizar capa</span>
                </label>
                <button type="submit" class="btnatualizarcapa" id="btnatualizarcapa" disabled>Atualizar</button>
            </form>
        </div>

        <!-- Exibir dados do perfil mais recente -->
        <?php
        $sqlDadosPerfil = "SELECT * FROM dados_perfil ORDER BY id DESC LIMIT 1"; // Obter dados mais recentes
        $resultPerfil = $conn->query($sqlDadosPerfil);

        if ($resultPerfil && $resultPerfil->num_rows > 0) {
            // Recuperar e exibir dados do perfil
            $registro = $resultPerfil->fetch_assoc();
            $nome = $registro['nome'];
            $idade = $registro['idade'];
            $rua = $registro['rua'];
            $bairro = $registro['bairro'];
            $estado = $registro['estado'];
            $bio = $registro['bio'];

            echo "<p class='nome'>NOME: $nome</p>";
            echo "<p class='idade'>IDADE: $idade</p>";
            echo "<p class='endereco'>ENDEREÇO: $rua, $bairro, $estado</p>";
            echo "<p class='bio'>BIO: $bio</p>";
        } else {
            echo "<p class='nreg'>Nenhum registro encontrado.</p>";
        }

        // Fechar conexão
        $conn->close();
        ?>

        <!-- Formulário para atualizar dados do perfil -->
        <form action="guardarDados.php" method="post">
            <p class="editar">Atualizar dados</p>
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" class="form-control" required>

            <label for="idade">Idade</label>
            <input type="number" id="idade" name="idade" class="form-control" required>

            <label para="rua">Rua</label>
            <input type="text" id="rua" name="rua" class="form-control" required>

            <label para="bairro">Bairro</label>
            <input type="text" id="bairro" name="bairro" class="form-control" required>

            <label para="estado">estado</label>
            <input type="text" id="estado" name="estado" class="form-control" required>

            <label para="bio">Bio</label>
            <textarea id="bio" name="bio" class="form-control" required></textarea>

            <div class="botao">
                <button type="submit" class="btn">Salvar</button>
            </div>
        </form>

    </article>

    <!-- Rodapé com links sociais -->
    <footer class="site-footer">
        <div class="footer-content">
            <p>© 2024 Emanuel.</p>
            <div class="social-links">
                <a href="https://www.instagram.com/manell.szl" target="_blank" class="social-link">Instagram</a>
                <a href="https://www.linkedin.com/in/emanuel-pereira-de-faria-b3b87a296" target="_blank" class="social-link">LinkedIn</a>
            </div>
        </div>
    </footer>

    <!-- Inclusão do arquivo JavaScript -->
    <script src="js/app.js"></script>

</body>

</html>
