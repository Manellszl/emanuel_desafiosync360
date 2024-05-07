// Verifica se o modo escuro está armazenado no localStorage
const isDarkMode = localStorage.getItem('darkMode');

// Se o modo escuro estiver ativado, ajusta a classe do corpo do documento
if (isDarkMode === 'true') {
    document.body.classList.add('dark'); // Adiciona a classe "dark"
    document.getElementById('chk').checked = true; // Marca o checkbox
}

// Obter o checkbox para troca de tema
const chk = document.getElementById('chk');

// Ouvinte de evento para alternar entre modo claro e escuro
chk.addEventListener('change', () => {
    document.body.classList.toggle('dark'); // Alterna o modo
    // Atualiza o localStorage com o novo estado do modo escuro
    localStorage.setItem('darkMode', document.body.classList.contains('dark'));
});

// Função para exibir o iframe
function exibirIframe() {
    const iframe = document.getElementById("iframe");
    const fecharBtn = document.querySelector('.fechariframe');

    if (iframe) {
        iframe.style.display = "block";  // Exibe o iframe
    }

    if (fecharBtn) {
        fecharBtn.style.display = "block";  // Exibe o botão para fechar o iframe
    }
}

// Função para fechar o iframe
function fecharIframe() {
    const iframe = document.getElementById("iframe");

    if (iframe) {
        iframe.style.display = "none";  // Oculta o iframe
    }

    const fecharBtn = document.querySelector('.fechariframe');
    if (fecharBtn) {
        fecharBtn.style.display = "none";  // Oculta o botão de fechamento
    }
    
    // Recarrega a página para garantir uma atualização limpa
    window.location.reload(); 
}

// Elementos para o upload de arquivos
const inputFile = document.getElementById("arquivocapa");
const submitButton = document.getElementById("btnatualizarcapa");
const nomeArquivoSpan = document.getElementById("atucapa");

// Função para verificar se o botão de envio deve ser habilitado
function verificarArquivo() {
    // Se um arquivo for selecionado, habilita o botão e mostra o nome do arquivo
    if (inputFile.files.length > 0) { 
        nomeArquivoSpan.textContent = inputFile.files[0].name; // Mostra o nome do arquivo
        submitButton.disabled = false; // Habilita o botão
    } else {
        submitButton.disabled = true; // Desabilita o botão se nenhum arquivo for selecionado
    }
}

// Ouvinte para verificar mudanças no input de arquivo
inputFile.addEventListener("change", verificarArquivo);

// Chama a função para definir o estado inicial do botão
verificarArquivo(); // Para desabilitar o botão se não houver arquivo inicialmente

// Função para exibir o botão de atualização da capa
function exibirButton() {
    const exibirButton = document.getElementById("btnatualizarcapa");
    
    // Verifica se o botão existe antes de tentar exibir
    if (exibirButton) {
        exibirButton.style.display = "block"; // Exibe o botão para atualização
    }
}

// Ouvinte para mensagens enviadas de outras partes do código (por exemplo, iframe)
window.addEventListener("message", function (event) {
    if (event.data === 'fecharIframe') {
        fecharIframe(); // Fecha o iframe quando recebe uma mensagem específica
    }
});