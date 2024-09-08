<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- Formulário de Escolha de Pagamento -->
<form method="POST" action="">
    <div class="pagamento-form">
        <label for="forma_pagamento">Escolha a Forma de Pagamento:</label>
        <select name="forma_pagamento" id="forma_pagamento">
            <option value="credito">Cartão de Crédito</option>
            <option value="debito">Cartão de Débito</option>
            <option value="boleto">Boleto Bancário</option>
        </select>

        <label for="cupom_desconto">Cupom de Desconto:</label>
        <input type="text" name="cupom_desconto" placeholder="Insira o valor do cupom">

        <label for="tipo_transporte">Escolha o Tipo de Transporte:</label>
        <select name="tipo_transporte" id="tipo_transporte">
            <option value="0">Sem Transporte</option>
            <optgroup label="Passagens Aéreas">
                <option value="50">Classe Econômica - R$ 50,00</option>
                <option value="150">Classe Executiva - R$ 150,00</option>
                <option value="300">Primeira Classe - R$ 300,00</option>
            </optgroup>
            <optgroup label="Passagens Terrestres">
                <option value="20">Ônibus - R$ 20,00</option>
                <option value="40">Trem - R$ 40,00</option>
            </optgroup>
            <optgroup label="Navios">
                <option value="100">Cabine Comum - R$ 100,00</option>
                <option value="200">Cabine Luxo - R$ 200,00</option>
            </optgroup>
        </select>

        <input type="submit" value="Calcular Total">
    </div>
</form>
