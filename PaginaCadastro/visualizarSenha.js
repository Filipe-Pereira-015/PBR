document.addEventListener("DOMContentLoaded", function () {
    var senhaInput = document.querySelector('input[name="senha"]');
    var visualizarSenhaCheckbox = document.getElementById('visualizarSenha');

    visualizarSenhaCheckbox.addEventListener('change', function () {
        // Alterna a visibilidade da senha com base na marcação da caixa de seleção
        senhaInput.type = this.checked ? 'text' : 'password';
    });
});
