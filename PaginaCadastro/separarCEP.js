document.addEventListener("DOMContentLoaded", function () {
    var cepInput = document.querySelector('input[name="cep"]');
    
    cepInput.addEventListener('input', function () {
        // Remove caracteres não numéricos do valor do CEP
        var cepValue = this.value.replace(/\D/g, '');

        // Adiciona os pontos e hífen ao CEP formatado
        cepValue = cepValue.replace(/(\d{5})(\d{3})/, '$1-$2');

        // Define o valor formatado de volta no campo de entrada
        this.value = cepValue;
    });
});
