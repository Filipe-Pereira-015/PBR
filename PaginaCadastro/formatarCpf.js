document.addEventListener("DOMContentLoaded", function () {
    var cpfInput = document.querySelector('input[name="cpf"]');

    cpfInput.addEventListener("input", function () {
        // Remove todos os caracteres não numéricos
        var cleanedValue = this.value.replace(/\D/g, "");

        // Adiciona a máscara do CPF
        var formattedValue = formatCPF(cleanedValue);

        // Atualiza o valor do campo
        this.value = formattedValue;
    });

    function formatCPF(value) {
        var formattedCPF = value.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
        return formattedCPF;
    }
});
