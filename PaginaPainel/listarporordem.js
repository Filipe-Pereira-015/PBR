function ordenarPorChavePrimaria(columnIndex, direction) {
    var table = document.getElementById("usuariosTable");
    var rows = Array.from(table.rows).slice(1); // Ignora a primeira linha (cabeçalho)
    var asc = direction === "asc";

    rows.sort(function (a, b) {
        var x = a.cells[columnIndex].innerText.toLowerCase();
        var y = b.cells[columnIndex].innerText.toLowerCase();
        return asc ? x.localeCompare(y) : y.localeCompare(x);
    });

    // Atualiza a tabela com as linhas ordenadas
    table.tBodies[0].innerHTML = ""; // Limpa o corpo da tabela
    table.tBodies[0].append(...rows);
}
